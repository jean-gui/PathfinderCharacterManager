<?php

namespace App\Controller;

use App\Entity\Characters\Character;
use App\Entity\Characters\CharacterClassPower;
use App\Entity\Characters\InventoryItem;
use App\Entity\Characters\InventoryPotion;
use App\Entity\Characters\PotionEffect;
use App\Entity\Characters\PowerEffect;
use App\Entity\Characters\SpellEffect;
use App\Entity\Rules\ClassDefinition;
use App\Entity\Rules\ClassSpell;
use App\Entity\Rules\CommonPower;
use App\Entity\Rules\Skill;
use App\Entity\Rules\Spell;
use App\Form\BaseCharacterType;
use App\Form\CastSpellsType;
use App\Form\ChangeHpType;
use App\Form\EditInventoryType;
use App\Form\EditPotionsType;
use App\Form\EquipmentType;
use App\Form\InventoryType;
use App\Form\LearnSpellType;
use App\Form\Notes\NotesType;
use App\Form\PowersActivationType;
use App\Form\PrepareSpellsType;
use App\Form\UncastSpellsType;
use App\Services\CharacterEquipment;
use App\Services\SpellCasting;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use function Symfony\Component\String\u;

/**
 * Character controller.
 *
 * @Route("/characters")
 */
class CharacterController extends AbstractController
{
    /**
     * Creates a form to create a Character entity.
     *
     * @param Character $character The entity
     *
     * @return FormInterface The form
     */
    private function createCreateForm(Character $character): FormInterface
    {
        $form = $this->createForm(
            BaseCharacterType::class,
            $character,
            array(
                'action' => $this->generateUrl('characters_new'),
                'method' => 'POST',
            )
        );

        $form->add('submit', SubmitType::class, array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Character entity.
     *
     * @Route("/new", name="characters_new")
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $character = new Character();
        $form = $this->createCreateForm($character);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /** @var $token TokenInterface */
                $character->setUser($this->getUser());

                $em = $this->getDoctrine()->getManager();
                $em->persist($character);
                $em->flush();

                return $this->redirect(
                    $this->generateUrl(
                        'characters_levelup',
                        array('id' => $character->getId())
                    )
                );
            }
        }

        $ability_scores = $this->getParameter('ability_scores');

        return $this->render(
            'character/new.html.twig',
            [
                'entity'         => $character,
                'form'           => $form->createView(),
                'ability_scores' => $ability_scores,
            ]
        );
    }

    /**
     * Finds and displays a Character entity.
     *
     * @Route("/{id}", name="characters_show", methods={"GET", "POST"})
     * @Template()
     * @Security("request.isMethodSafe() or is_granted('CHARACTER_EDIT', character) or is_granted('ROLE_ADMIN')")
     *
     * @param Character          $character
     * @param Request            $request
     * @param PublisherInterface $publisher
     *
     * @return array|RedirectResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function showAction(Character $character, Request $request, PublisherInterface $publisher)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $needActivationFeats = array();
        $passiveFeats = array();
        $otherFeats = array();
        foreach ($character->getFeats() as $characterFeat) {
            if (!$characterFeat->getFeat()->hasEffects()) {
                $otherFeats[] = $characterFeat;
            } elseif (!$characterFeat->getFeat()->isPassive() || $characterFeat->getFeat()->hasExternalConditions()) {
                $needActivationFeats[] = $characterFeat;
            } else {
                $passiveFeats[] = $characterFeat;
            }
        }

        $needActivationClassPowers = array();
        $passiveClassPowers        = array();
        $otherClassPowers       = array();
        foreach ($character->getClassPowers() as $classPower) {
            $power = $classPower->getClassPower();

            if ($power->hasEffects()) {
                $useless = 0;
                if (array_key_exists('feat', $power->getEffects())) {
                    $useless++;
                }
                if (array_key_exists('extra_feats', $power->getEffects())) {
                    $useless++;
                }

                if ($useless == count($power->getEffects())) {
                    // Don't add a power if it has no meaningful bonuses for the character sheet
                    continue;
                }

                if (!$power->isPassive() || $power->hasExternalConditions() || $power->isCastable()) {
                    $needActivationClassPowers[] = $classPower;
                } else {
                    $passiveClassPowers[] = $classPower;
                }
            } else {
                $otherClassPowers[] = $classPower;
            }
        }

        $needActivationSpellEffects = array();
        $passiveSpellEffects        = array();
        $otherSpellEffects          = array();
        foreach ($character->getSpellEffects() as $spellEffect) {
            $spell = $spellEffect->getSpell();
            if (!$spell->hasEffects()) {
                $otherSpellEffects[] = $spellEffect;
            } elseif (!$spell->isPassive() || $spell->hasExternalConditions()) {
                $needActivationSpellEffects[] = $spellEffect;
            } else {
                $passiveSpellEffects[] = $spellEffect;
            }
        }

        $needActivationPotionEffects = [];
        foreach ($character->getPotionEffects() as $potionEffect) {
            $spell = $potionEffect->getPotion()->getSpell();
            if ($spell->hasEffects() && (!$spell->isPassive() || $spell->hasExternalConditions())) {
                $needActivationPotionEffects[] = $potionEffect;
            }
        }

        $needActivationPowerEffects = [];
        $passivePowerEffects        = [];
        $otherPowerEffects          = [];
        foreach ($character->getPowerEffects() as $powerEffect) {
            $power = $powerEffect->getPower();
            if (!$power->hasEffects()) {
                $otherPowerEffects[] = $powerEffect;
            } elseif (!$power->isPassive() || $power->hasExternalConditions()) {
                $needActivationPowerEffects[] = $powerEffect;
            } else {
                $passivePowerEffects[] = $powerEffect;
            }
        }

        $powersActivationForm = $this->createForm(PowersActivationType::class, $character);
        $powersActivationForm->get('feats')->setData($needActivationFeats);
        $powersActivationForm->get('class_powers')->setData($needActivationClassPowers);
        $powersActivationForm->get('spell_effects')->setData($needActivationSpellEffects);
        $powersActivationForm->get('potion_effects')->setData($needActivationPotionEffects);
        $powersActivationForm->get('power_effects')->setData($needActivationPowerEffects);
        $powersActivationForm->handleRequest($request);

        if ($powersActivationForm->isSubmitted() && $powersActivationForm->isValid()) {
            if (array_key_exists('class_powers', $request->request->get('powers_activation'))) {
                foreach ($request->request->get('powers_activation')['class_powers'] as $key => $value) {
                    /** @var $ccp CharacterClassPower */
                    $ccp = $powersActivationForm->get('class_powers')->get($key)->getData();

                    if (array_key_exists('cancel', $value) && $value['cancel']) {
                        foreach ($character->getParty()->getCharacters() as $target) {
                            foreach ($target->getPowerEffects() as $powerEffect) {
                                if ($powerEffect->getCaster() === $character && $powerEffect->getPower() === $ccp->getClassPower()) {
                                    $target->removePowerEffect($powerEffect);
                                    break;
                                }
                            }

                            $this->publishCharacterUpdate($publisher, $target);
                        }
                    }

                    if (
                        $ccp instanceof CharacterClassPower &&
                        $ccp->getClassPower()->isCastable() &&
                        array_key_exists('active', $value)
                    ) {
                        $target = $value['active'];
                        if (in_array('other', $target)) {
                            // nothing to do
                        } elseif (in_array('allies', $target)) {
                            foreach ($character->getParty()->getCharacters() as $target) {
                                $target->addPowerEffect(
                                    (new PowerEffect())
                                        ->setPower($ccp->getClassPower())
                                        ->setCaster($character)
                                        ->setCasterLevel($character->getLevel($ccp->getClassPower()->getClass()))
                                );

                                $this->publishCharacterUpdate($publisher, $target);
                            }
                        } else {
                            /** @var $target Character */
                            $targets = $em->getRepository(Character::class)->findBy(['id' => $value['active']]);
                            foreach ($targets as $target) {
                                $target->addPowerEffect(
                                    (new PowerEffect())
                                        ->setPower($ccp->getClassPower())
                                        ->setCaster($character)
                                        ->setCasterLevel($character->getLevel($ccp->getClassPower()->getClass()))
                                );

                                $this->publishCharacterUpdate($publisher, $target);
                            }
                        }
                    }
                }
            }

            $em->flush();

            return $this->redirect($this->generateUrl('characters_show', array('id' => $character->getId())));
        }

        $allSkills = $em->getRepository(Skill::class)->findAll();
        $skills = array_filter($allSkills, function (Skill $skill) use ($character) {
            if ($skill->getUntrained() || $character->getSkillRank($skill) > 0) {
                return true;
            }

            return false;
        });

        return array(
            'entity' => $character,
            'powers_activation_form' => $powersActivationForm->createView(),
            'skills' => $skills,
            'passive_feats' => $passiveFeats,
            'passive_class_powers' => $passiveClassPowers,
            'other_feats' => $otherFeats,
            'other_class_powers' => $otherClassPowers,
            'passive_spell_effects' => $passiveSpellEffects,
            'other_spell_effects' => $otherSpellEffects,
            'passive_power_effects' => $passivePowerEffects,
            'other_power_effects'   => $otherPowerEffects,
        );
    }

    /**
     * Display a character's equipment
     *
     * @Route("/{id}/inventory/edit", name="character_inventory_edit")
     * @Security("request.isMethodSafe() or is_granted('CHARACTER_EDIT', character) or is_granted('ROLE_ADMIN')")
     *
     * @param Character $character
     * @param Request $request
     *
     * @return Response
     */
    public function editInventory(Character $character, Request $request)
    {
        $inventoryForm = $this->createForm(
            EditInventoryType::class,
            $character,
            array('method' => 'PUT')
        )->add('submit', SubmitType::class);

        $inventoryForm->handleRequest($request);
        if ($inventoryForm->isSubmitted() && $inventoryForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect(
                $this->generateUrl(
                    'character_inventory',
                    ['id' => $character->getId()]
                )
            );
        }

        return $this->render(
            'character/edit_inventory.html.twig',
            [
                'entity'        => $character,
                'inventoryForm' => $inventoryForm->createView(),
            ]
        );
    }

    /**
     * Display a character's equipment
     *
     * @Route("/{id}/inventory", name="character_inventory")
     * @Security("request.isMethodSafe() or is_granted('CHARACTER_EDIT', character) or is_granted('ROLE_ADMIN')")
     *
     * @param Character          $character
     * @param Request            $request
     *
     * @param CharacterEquipment $characterEquipment
     * @param PublisherInterface $publisher
     *
     * @return RedirectResponse|Response
     */
    public function showEquipment(
        Character $character,
        Request $request,
        CharacterEquipment $characterEquipment,
        PublisherInterface $publisher
    ) {
        $em = $this->getDoctrine()->getManager();

        $equipmentForm = $this->createForm(
            EquipmentType::class,
            $character->getEquipment(),
            ['method' => 'PUT']
        );
        if ($request->getMethod() === 'PUT' && $request->request->get('equipment')) {
            foreach ($request->request->get('equipment') as $slot => $unequip) {
                if ($slot !== '_token') {
                    $characterEquipment->unequipSlot($character, $slot);
                    $em->flush();

                    $this->publishCharacterUpdate($publisher, $character);

                    return $this->redirect(
                        $this->generateUrl(
                            'character_inventory',
                            ['id' => $character->getId()]
                        )
                    );
                }
            }
        }

        $inventoryForm = $this->createForm(
            InventoryType::class,
            $character,
            array('method' => 'PUT')
        );
        if ($request->getMethod() === 'PUT' && $request->request->get('inventory')) {
            $inventoryForm->handleRequest($request);

            foreach ($inventoryForm->get('unequippedInventory')->all() as $child) {
                if ($child->has('equip')) {
                    /** @var SubmitButton $equip */
                    $equip = $child->get('equip');
                    if ($equip->isClicked()) {
                        try {
                            /** @var InventoryItem $inventoryItem */
                            $inventoryItem = $child->getData();
                            $characterEquipment->equip(
                                $character,
                                $inventoryItem->getItem()
                            );

                            $em->flush();
                        } catch (Exception $e) {
                            $this->addFlash('danger', $child->getData().' is not equippable');
                        }

                        $this->publishCharacterUpdate($publisher, $character);

                        return $this->redirect(
                            $this->generateUrl(
                                'character_inventory',
                                ['id' => $character->getId()]
                            )
                        );
                    }
                }

                /** @var SubmitButton $drop */
                $drop = $child->get('drop');
                if ($drop->isClicked()) {
                    $character->removeInventoryItem($child->getData());
                    $em->flush();

                    return $this->redirect(
                        $this->generateUrl(
                            'character_inventory',
                            ['id' => $character->getId()]
                        )
                    );
                }
            }
        }

        return $this->render(
            'character/show_equipment.html.twig',
            [
                'entity' => $character,
                'equipmentForm' => $equipmentForm->createView(),
                'inventoryForm' => $inventoryForm->createView(),
            ]
        );
    }

    /**
     * Show character spell casting form
     *
     * @Route("/{id}/spells", name="character_spells")
     * @Template()
     * @Security("request.isMethodSafe() or is_granted('CHARACTER_EDIT', character) or is_granted('ROLE_ADMIN')")
     *
     * @param Character          $character
     * @param Request            $request
     * @param SpellCasting       $spellCasting
     * @param PublisherInterface $publisher
     *
     * @return array|RedirectResponse
     * @throws Exception
     */
    public function showCharacterSpells(
        Character $character,
        Request $request,
        SpellCasting $spellCasting,
        PublisherInterface $publisher
    ) {
        $em = $this->getDoctrine()->getManager();

        $castSpellsForm = $this->createForm(
            CastSpellsType::class,
            $character,
            ['method' => 'PUT']
        );

        if ($request->getMethod() === 'PUT') {
            $values = $request->request->all('cast_spells');
            foreach ($values['castable_spells_by_class_by_spell_level'] as $classKey => $classValue) {
                foreach ($classValue['spells_by_level'] as $levelKey => $levelValue) {
                    foreach ($levelValue['spells'] as $spellKey => $spellValue) {
                        if (array_key_exists('id', $spellValue)) {
                            $target = $spellValue['targets'];
                            /** @var ClassDefinition $class */
                            $class = $castSpellsForm
                                ->get('castable_spells_by_class_by_spell_level')
                                ->get($classKey)
                                ->getData()
                                ->getClass();

                            /** @var Spell $spellValue */
                            $spell = $castSpellsForm
                                ->get('castable_spells_by_class_by_spell_level')
                                ->get($classKey)
                                ->get('spells_by_level')
                                ->get($levelKey)
                                ->get('spells')
                                ->get($spellKey)
                                ->getData();

                            if ($class->isPreparationNeeded()) {
                                $level = null;
                            } else {
                                $level = (int)$spellValue['level'];
                            }

                            // Should probably break here
                        }
                    }
                }
            }

            // Is isset appropriate?
            if (isset($target, $spell, $class)) {
                try {
                    if (in_array('other', $target)) {
                        $spellCasting->cast($character, $spell, $class, null, $level);
                    } elseif (in_array('allies', $target)) {
                        $spellCasting->cast(
                            $character,
                            $spell,
                            $class,
                            $character->getParty()->getCharacters()->toArray(),
                            $level
                        );
                    } else {
                        $targets = $em->getRepository(Character::class)->findBy(['id' => $target]);
                        if ($target) {
                            $spellCasting->cast($character, $spell, $class, $targets, $level);
                        }
                    }
                } catch (Exception $e) {
                    $this->addFlash('danger', $e->getMessage());
                }

                return $this->redirect($this->generateUrl('character_spells', array('id' => $character->getId())));
            }
        }

        $uncastSpellsForm = $this->createForm(UncastSpellsType::class, $character);
        $uncastSpellsForm->handleRequest($request);
        if ($uncastSpellsForm->isSubmitted() && $uncastSpellsForm->isValid()) {
            foreach ($uncastSpellsForm->all() as $f) {
                if ($f->getName() === 'Uncast') {
                    continue;
                }

                if ($f->getData()['uncast'] === true) {
                    /** @var $spellEffect SpellEffect */
                    $spellEffect = $f->getConfig()->getOption('spellEffect');
                    $target = $spellEffect->getCharacter();
                    $target->removeSpellEffect($spellEffect);

                    $this->publishCharacterUpdate($publisher, $target);
                }
            }
            $em->flush();

            return $this->redirect($this->generateUrl('character_spells', ['id' => $character->getId()]));
        }

        return array(
            'entity'                 => $character,
            'castSpellsForm'         => $castSpellsForm->createView(),
            'uncastSpellsForm'       => $uncastSpellsForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Character entity.
     *
     * @Route("/{id}/edit", name="characters_edit")
     * @Template()
     * @Security("is_granted('CHARACTER_EDIT', character) or is_granted('ROLE_ADMIN')")
     *
     * @param Character $character
     *
     * @return array
     */
    public function edit(Character $character)
    {
        $editForm = $this->createEditForm($character);

        return array(
            'entity' => $character,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Character entity.
     *
     * @param Character $character The entity
     *
     * @return FormInterface The form
     */
    private function createEditForm(Character $character)
    {
        $form = $this->createForm(
            BaseCharacterType::class,
            $character,
            array(
                'action' => $this->generateUrl('characters_update', array('id' => $character->getId())),
                'method' => 'PUT',
            )
        );

        $form->add('submit', SubmitType::class, array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Character entity.
     *
     * @Route("/{id}/update", name="characters_update", methods={"GET", "POST", "PUT"})
     * @Template("character/edit.html.twig")
     * @Security("is_granted('CHARACTER_EDIT', character) or is_granted('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param Character $character
     *
     * @return array|RedirectResponse
     */
    public function update(Request $request, Character $character)
    {
        $em = $this->getDoctrine()->getManager();

        $editForm = $this->createEditForm($character);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Update successful');

            return $this->redirect($this->generateUrl('characters_show', array('id' => $character->getId())));
        }

        return array(
            'entity' => $character,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Character entity.
     *
     * @Route("/{id}", name="characters_delete", methods={"DELETE"})
     * @Security("is_granted('CHARACTER_EDIT', character) or is_granted('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param Character $character
     *
     * @return RedirectResponse
     */
    public function delete(Request $request, Character $character): Response
    {
        if ($this->isCsrfTokenValid('delete'.$character->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($character);
            $entityManager->flush();
        }

        return $this->redirectToRoute('index');
    }

    /**
     * Make character sleep.
     *
     * @Route("/{id}/sleep", name="characters_sleep")
     * @Security("request.isMethodSafe() or is_granted('CHARACTER_EDIT', character) or is_granted('ROLE_ADMIN')")
     *
     * @param Character    $character
     * @param Request      $request
     * @param SpellCasting $spellCasting
     *
     * @return Response
     */
    public function sleep(Character $character, Request $request, SpellCasting $spellCasting): Response
    {
        $spellCasting->fixPreparedSpells($character);
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(PrepareSpellsType::class, $character);
        $form->add('sleep', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $character->setNonPreparedCastSpellsCount(null);
            foreach ($character->getPreparedSpells() as $preparedSpell) {
                $preparedSpell->setAlreaydCast(false);
            }

            // Reset counters
            foreach ($character->getCounters() as $counter) {
                if ($counter->isResetOnSleep()) {
                    $counter->setCurrent(0);
                }
            }

            $em->flush();

            return $this->redirect($this->generateUrl('characters_show', array('id' => $character->getId())));
        }

        return $this->render('character/sleep.html.twig', ['form' => $form->createView(), 'entity' => $character]);
    }

    /**
     * Make character prepare spells.
     *
     * @Route("/{id}/prepare_spells", name="characters_prepare_spells")
     * @Security("request.isMethodSafe() or is_granted('CHARACTER_EDIT', character) or is_granted('ROLE_ADMIN')")
     *
     * @param Character    $character
     * @param Request      $request
     * @param SpellCasting $spellCasting
     *
     * @return Response
     */
    public function prepareSpells(Character $character, Request $request, SpellCasting $spellCasting): Response
    {
        $spellCasting->fixPreparedSpells($character);
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(PrepareSpellsType::class, $character, ['disable_not_empty' => true]);
        $form->add('prepare_spells', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('characters_show', ['id' => $character->getId()]));
        }

        return $this->render(
            'character/prepare_spells.html.twig',
            ['form' => $form->createView(), 'entity' => $character]
        );
    }

    /**
     * View and change a character's hit points.
     *
     * @Route("/{id}/hitpoints", name="characters_hitpoints")
     * @Template()
     * @Security("request.isMethodSafe() or is_granted('CHARACTER_EDIT', character) or is_granted('ROLE_ADMIN')")
     *
     * @param Character          $character
     * @param Request            $request
     * @param PublisherInterface $publisher
     *
     * @return Response
     */
    public function hitPoints(Character $character, Request $request, PublisherInterface $publisher)
    {
        $hpForm = $this->createForm(
            ChangeHpType::class,
            $character,
            array(
                'method' => 'PUT',
                'action' => $this->generateUrl('characters_hitpoints', array('id' => $character->getId())),
            )
        );

        $hpForm->handleRequest($request);
        if ($hpForm->isSubmitted() && $hpForm->isValid()) {
            $character->changeHp($hpForm->get('hp_mod')->getData());
            $this->getDoctrine()->getManager()->flush();

            $this->publishCharacterUpdate($publisher, $character);

            return $this->redirect($this->generateUrl('characters_show', array('id' => $character->getId())));
        }

        return $this->render(
            'character/hit_points.html.twig',
            [
                'character' => $character,
                'form'      => $hpForm->createView(),
            ]
        );
    }

    /**
     * Character notes.
     *
     * @Route(
     *     "/{id}/notes/{type}",
     *     name="characters_notes",
     *     requirements={"type" = "general|power|inventory|spell"},
     *     defaults={"type" = "general"}
     * )
     * @Template()
     * @Security("request.isMethodSafe() or is_granted('CHARACTER_EDIT', character) or is_granted('ROLE_ADMIN')")
     *
     * @param Character $character
     * @param $type
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function notes(Character $character, $type, Request $request)
    {
        $form = $this->createForm(
            NotesType::class,
            $character,
            array(
                'type'   => $type,
                'method' => 'PUT',
                'action' => $this->generateUrl(
                    'characters_notes',
                    array('id' => $character->getId(), 'type' => $type)
                ),
            )
        );
        $form->add('submit', SubmitType::class, array('label' => 'Save notes'));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            switch ($type) {
                case 'inventory':
                    $route = 'character_inventory';
                    break;
                case 'spell':
                    $route = 'character_spells';
                    break;
                default:
                    $route = 'characters_show';
            }

            return $this->redirect($this->generateUrl($route, array('id' => $character->getId())));
        }

        return array('form' => $form->createView());
    }

    /**
     * Learn spell
     *
     * @Route(
     *     "/{id}/learn-spell",
     *     name="characters_learn_spell",
     * )
     * @Template()
     * @Security("request.isMethodSafe() or is_granted('CHARACTER_EDIT', character) or is_granted('ROLE_ADMIN')")
     *
     * @param Character $character
     * @param Request   $request
     *
     * @return array|RedirectResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function learnSpell(Character $character, Request $request)
    {
        if (!$character->canLearnSpells()) {
            throw new NotFoundHttpException('This character cannot learn spells');
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(
            LearnSpellType::class,
            $character,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl(
                    'characters_learn_spell',
                    ['id' => $character->getId()]
                ),
            ]
        );
        $form->add('submit', SubmitType::class, ['label' => 'Learn Spell']);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ClassSpell $spell */
            $spell = $form->get('spell')->getData();
            $character->addExtraSpell($spell);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', $spell.' learned  successfully');

            return $this->redirect($this->generateUrl('characters_learn_spell', ['id' => $character->getId()]));
        }

        return array('form' => $form->createView());
    }

    /**
     * Edit potions
     *
     * @Route("/{id}/potions/edit", name="character_potions_edit")
     * @Security("request.isMethodSafe() or is_granted('CHARACTER_EDIT', character) or is_granted('ROLE_ADMIN')")
     *
     * @param Character $character
     * @param Request   $request
     *
     * @return Response
     */
    public function editPotions(Character $character, Request $request): Response
    {
        $form = $this->createForm(
            EditPotionsType::class,
            $character,
            ['method' => 'PUT']
        )->add('submit', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect(
                $this->generateUrl(
                    'character_inventory',
                    ['id' => $character->getId()]
                )
            );
        }

        return $this->render(
            'character/edit_potions.html.twig',
            [
                'entity' => $character,
                'form'   => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{character}/potions/{potion}/drink", name="character_potions_drink", methods={"GET", "POST"})
     * @ParamConverter("character", options={"mapping": {"character": "id"}})
     * @ParamConverter("inventoryPotion", options={"mapping": {"potion": "id"}})
     * @Security("is_granted('CHARACTER_EDIT', character) or is_granted('ROLE_ADMIN')")
     *
     * @param Character          $character
     * @param InventoryPotion    $inventoryPotion
     * @param PublisherInterface $publisher
     *
     * @return Response
     */
    public function drinkPotion(
        Character $character,
        InventoryPotion $inventoryPotion,
        PublisherInterface $publisher
    ): Response {
        if ($character !== $inventoryPotion->getCharacter()) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();

        if ($inventoryPotion->getQuantity() === 0) {
            $character->removePotion($inventoryPotion);
        } else {
            if ($inventoryPotion->getQuantity() === 1) {
                $character->removePotion($inventoryPotion);
            } else {
                $inventoryPotion->setQuantity($inventoryPotion->getQuantity() - 1);
            }

            $potion = $inventoryPotion->getPotion();

            if (!$potion->isInstantaneous()) {
                $effect = new PotionEffect();
                $effect->setPotion($potion)->setCharacter($character);
                $em->persist($effect);
            }
        }

        $em->flush();
        $this->publishCharacterUpdate($publisher, $character);

        return $this->redirectToRoute('character_inventory', ['id' => $character->getId()]);
    }

    /**
     * @Route("/{character}/potions/{potion}/stop", name="character_potions_stop", methods={"GET", "POST"})
     * @ParamConverter("character", options={"mapping": {"character": "id"}})
     * @ParamConverter("potionEffect", options={"mapping": {"potion": "id"}})
     * @Security("is_granted('CHARACTER_EDIT', character) or is_granted('ROLE_ADMIN')")
     *
     * @param Character    $character
     * @param PotionEffect $potionEffect
     *
     * @return Response
     */
    public function stopPotion(Character $character, PotionEffect $potionEffect): Response
    {
        if ($character !== $potionEffect->getCharacter()) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($potionEffect);
        $em->flush();

        return $this->redirectToRoute('characters_show', ['id' => $character->getId()]);
    }

    /**
     * @param PublisherInterface $publisher
     * @param Character          $character
     */
    protected function publishCharacterUpdate(PublisherInterface $publisher, Character $character): void
    {
        try {
            $publisher(
                new Update(
                    'https://pathfinder.troulite.fr/characters/'.$character->getId(),
                    json_encode(['character' => $character->getId(), 'message' => $character->getName().' changed'])
                )
            );
        } catch (Exception $e) {
        }
    }
}

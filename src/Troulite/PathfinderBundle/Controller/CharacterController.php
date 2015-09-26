<?php

/*
 * Copyright 2015 Jean-Guilhem Rouel
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Troulite\PathfinderBundle\Controller;

use Doctrine\ORM\EntityManager;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Troulite\PathfinderBundle\Entity\Character;
use Troulite\PathfinderBundle\Entity\CharacterClassPower;
use Troulite\PathfinderBundle\Entity\ClassDefinition;
use Troulite\PathfinderBundle\Entity\ClassSpell;
use Troulite\PathfinderBundle\Entity\InventoryItem;
use Troulite\PathfinderBundle\Entity\PowerEffect;
use Troulite\PathfinderBundle\Entity\Skill;
use Troulite\PathfinderBundle\Entity\Spell;
use Troulite\PathfinderBundle\Entity\SpellEffect;
use Troulite\PathfinderBundle\Form\BaseCharacterType;
use Troulite\PathfinderBundle\Form\CastSpellsType;
use Troulite\PathfinderBundle\Form\ChangeHpType;
use Troulite\PathfinderBundle\Form\EditInventoryType;
use Troulite\PathfinderBundle\Form\EquipmentType;
use Troulite\PathfinderBundle\Form\InventoryType;
use Troulite\PathfinderBundle\Form\LearnSpellType;
use Troulite\PathfinderBundle\Form\Notes\NotesType;
use Troulite\PathfinderBundle\Form\PowersActivationType;
use Troulite\PathfinderBundle\Form\SleepType;
use Troulite\PathfinderBundle\Form\UncastSpellsType;

/**
 * Character controller.
 *
 * @Route("/characters")
 */
class CharacterController extends Controller
{

    /**
     * Lists all Character entities.
     *
     * @Route("/", name="characters")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TroulitePathfinderBundle:Character')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a form to create a Character entity.
     *
     * @param Character $character The entity
     *
     * @return Form The form
     */
    private function createCreateForm(Character $character)
    {
        $form = $this->createForm(
            new BaseCharacterType($this->container->getParameter('character_advancement')),
            $character,
            array(
                'action' => $this->generateUrl('characters_new'),
                'method' => 'POST',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Character entity.
     *
     * @Route("/new", name="characters_new")
     * @Template()
     * @Secure(roles="ROLE_USER")
     *
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function newAction(Request $request)
    {
        $character = new Character();
        $form = $this->createCreateForm($character);

        if($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                /** @var $token TokenInterface */
                $token = $this->get('security.token_storage')->getToken();
                $character->setUser($token->getUser());

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

        $ability_scores = $this->container->getParameter('ability_scores');

        return array(
            'entity' => $character,
            'form' => $form->createView(),
            'ability_scores' => $ability_scores
        );
    }

    /**
     * Finds and displays a Character entity.
     *
     * @Route("/{id}", name="characters_show")
     * @Template()
     * @Security("request.isMethodSafe() or is_granted('CHARACTER_EDIT', character) or has_role('ROLE_ADMIN')")
     *
     * @param Character $character
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function showAction(Character $character, Request $request)
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

        $needActivationPowerEffects = array();
        $passivePowerEffects        = array();
        $otherPowerEffects          = array();
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

        $powersActivationForm = $this->createForm(new PowersActivationType());
        $powersActivationForm->get('feats')->setData($needActivationFeats);
        $powersActivationForm->get('class_powers')->setData($needActivationClassPowers);
        $powersActivationForm->get('spell_effects')->setData($needActivationSpellEffects);
        $powersActivationForm->get('power_effects')->setData($needActivationPowerEffects);
        $powersActivationForm->get('item_power_effects')->setData($character->getItemPowerEffects());
        $powersActivationForm->handleRequest($request);

        if ($powersActivationForm->isValid()) {
            if (array_key_exists('class_powers', $request->request->get('classpoweractivation'))) {
                foreach ($request->request->get('classpoweractivation')['class_powers'] as $key => $value) {
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
                        }
                    }

                    if (
                        $ccp instanceof CharacterClassPower &&
                        $ccp->getClassPower()->isCastable() &&
                        $value['active']
                    ) {
                        switch ($value['active']) {
                            case 'other':
                                break;
                            case 'allies':
                                foreach ($character->getParty()->getCharacters() as $target) {
                                    $target->addPowerEffect(
                                        (new PowerEffect())
                                            ->setPower($ccp->getClassPower())
                                            ->setCaster($character)
                                            ->setCasterLevel($character->getLevel($ccp->getClassPower()->getClass()))
                                    );
                                }
                                break;
                            default:
                                /** @var $target Character */
                                $target = $em->getRepository('TroulitePathfinderBundle:Character')->find($value['active']);
                                if ($target) {
                                    $target->addPowerEffect(
                                        (new PowerEffect())
                                            ->setPower($ccp->getClassPower())
                                            ->setCaster($character)
                                            ->setCasterLevel($character->getLevel($ccp->getClassPower()->getClass()))
                                    );
                                }
                                break;
                        }
                    }
                }
            }

            $em->flush();

            return $this->redirect($this->generateUrl('characters_show', array('id' => $character->getId())));
        }

        $skills = $em->getRepository('TroulitePathfinderBundle:Skill')->findAll();
        // Sort skills by name
        usort($skills, function (Skill $s1, Skill $s2) {
            return strcmp($s1->getName(), $s2->getName());
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
     * @Template()
     * @Security("request.isMethodSafe() or is_granted('CHARACTER_EDIT', character) or has_role('ROLE_ADMIN')")
     *
     * @param Character $character
     * @param Request $request
     *
     * @return array
     */
    public function editInventoryAction(Character $character, Request $request)
    {
        $inventoryForm = $this->createForm(
            new EditInventoryType(),
            $character,
            array('method' => 'PUT')
        )->add('submit', 'submit');

        $inventoryForm->handleRequest($request);
        if ($inventoryForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('character_inventory',
                array('id' => $character->getId())));
        }

        return array('entity' => $character, 'inventoryForm' => $inventoryForm->createView());
    }

    /**
     * Display a character's equipment
     *
     * @Route("/{id}/inventory", name="character_inventory")
     * @Template()
     * @Security("request.isMethodSafe() or is_granted('CHARACTER_EDIT', character) or has_role('ROLE_ADMIN')")
     *
     * @param Character $character
     * @param Request $request
     *
     * @return array
     */
    public function showEquipmentAction(Character $character, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $equipmentForm = $this->createForm(
            new EquipmentType(),
            $character->getEquipment(),
            array('method' => 'PUT')
        );
        if ($request->getMethod() === 'PUT' && $request->request->get('troulite_pathfinderbundle_equipment')) {
            foreach ($request->request->get('troulite_pathfinderbundle_equipment') as $slot => $unequip) {
                if ($slot !== '_token') {
                    $this->get('troulite_pathfinder.character_equipment')->unequipSlot($character, $slot);
                    $em->flush();
                    return $this->redirect($this->generateUrl('character_inventory',
                        array('id' => $character->getId())));
                }
            }
        }

        $inventoryForm = $this->createForm(
            new InventoryType(),
            $character,
            array('method' => 'PUT')
        );
        if ($request->getMethod() === 'PUT' && $request->request->get('troulite_pathfinderbundle_inventory')) {
            $inventoryForm->handleRequest($request);

            foreach($inventoryForm->get('unequipped_inventory')->all() as $child) {
                if ($child->has('equip')) {
                    /** @var SubmitButton $equip */
                    $equip = $child->get('equip');
                    if ($equip->isClicked()) {
                        try {
                            /** @var InventoryItem $inventoryItem */
                            $inventoryItem = $child->getData();
                            $this->get('troulite_pathfinder.character_equipment')->equip(
                                $character,
                                $inventoryItem->getItem()
                            );

                            $em->flush();
                        } catch (\Exception $e) {
                            $this->addFlash('danger', $child->getData() . ' is not equippable');
                        }
                        return $this->redirect($this->generateUrl('character_inventory',
                            array('id' => $character->getId())));
                    }
                }

                /** @var SubmitButton $drop */
                $drop = $child->get('drop');
                if ($drop->isClicked()) {
                    $character->removeInventoryItem($child->getData());
                    $em->flush();

                    return $this->redirect($this->generateUrl('character_inventory',
                        array('id' => $character->getId())));
                }
            }
        }

        return array(
            'entity' => $character,
            'equipmentForm' => $equipmentForm->createView(),
            'inventoryForm' => $inventoryForm->createView()
        );
    }

    /**
     * Show character spell casting form
     *
     * @Route("/{id}/spells", name="character_spells")
     * @Template()
     * @Security("request.isMethodSafe() or is_granted('CHARACTER_EDIT', character) or has_role('ROLE_ADMIN')")
     *
     * @param Character $character
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function showCharacterSpellsAction(Character $character, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $castSpellsForm = $this->createForm(
            new CastSpellsType($this->container->getParameter('bonus_spells')),
            $character,
            array('method' => 'PUT')
        );

        if ($request->getMethod() === 'PUT') {
            $values = $request->request->get('troulite_pathfinder_bundle_cast_spells');
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

                            // Should probably break here
                        }
                    }
                }
            }
            // Is isset appropriate?
            if (isset($target, $spell, $class)) {
                switch ($target) {
                    case 'other':
                        $this->get('troulite_pathfinder.spell_casting')->cast($character, $spell, $class);
                        break;
                    case 'allies':
                        $this->get('troulite_pathfinder.spell_casting')->cast(
                            $character,
                            $spell,
                            $class,
                            $character->getParty()->getCharacters()
                        );
                        break;
                    default:
                        $target = $em->getRepository('TroulitePathfinderBundle:Character')->find($target);
                        if ($target) {
                            $this->get('troulite_pathfinder.spell_casting')->cast($character, $spell, $class,
                                array($target));
                        }
                        break;
                }

                return $this->redirect($this->generateUrl('character_spells', array('id' => $character->getId())));
            }
        }

        $uncastSpellsForm = $this->createForm(new UncastSpellsType(), $character);
        $uncastSpellsForm->handleRequest($request);
        if ($uncastSpellsForm->isValid()) {
            /** @var FormInterface $f */
            foreach ($uncastSpellsForm->all() as $f) {
                if ($f->getName() === 'Uncast') {
                    continue;
                }

                if ($f->getData()['uncast'] === true) {
                    /** @var $spellEffect SpellEffect */
                    $spellEffect = $f->getConfig()->getOption('spellEffect');
                    $spellEffect->getCharacter()->removeSpellEffect($spellEffect);
                }
            }
            $em->flush();

            return $this->redirect($this->generateUrl('characters_show', array('id' => $character->getId())));
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
     * @Method("GET")
     * @Template()
     * @Security("is_granted('CHARACTER_EDIT', character) or has_role('ROLE_ADMIN')")
     *
     * @param Character $character
     *
     * @return array
     */
    public function editAction(Character $character)
    {
        $editForm = $this->createEditForm($character);
        $deleteForm = $this->createDeleteForm($character);

        return array(
            'entity' => $character,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Character entity.
     *
     * @param Character $character The entity
     *
     * @return Form The form
     */
    private function createEditForm(Character $character)
    {
        $form = $this->createForm(
            new BaseCharacterType($this->container->getParameter('character_advancement')),
            $character,
            array(
                'action' => $this->generateUrl('characters_update', array('id' => $character->getId())),
                'method' => 'PUT',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Character entity.
     *
     * @Route("/{id}/update", name="characters_update")
     * @Method("PUT")
     * @Template("TroulitePathfinderBundle:Character:edit.html.twig")
     * @Security("is_granted('CHARACTER_EDIT', character) or has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param Character $character
     *
     * @return array|RedirectResponse
     */
    public function updateAction(Request $request, Character $character)
    {
        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($character);
        $editForm = $this->createEditForm($character);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Update successful');

            return $this->redirect($this->generateUrl('characters_show', array('id' => $character->getId())));
        }

        return array(
            'entity' => $character,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Character entity.
     *
     * @Route("/{id}", name="characters_delete")
     * @Method("DELETE")
     * @Security("is_granted('CHARACTER_EDIT', character) or has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param Character $character
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Character $character)
    {
        $form = $this->createDeleteForm($character);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $character = $em->getRepository('TroulitePathfinderBundle:Character')->find($character->getId());

            if (!$character) {
                throw $this->createNotFoundException('Unable to find Character entity.');
            }

            $em->remove($character);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('characters'));
    }

    /**
     * Creates a form to delete a Character entity by id.
     *
     * @param mixed $character The entity id
     *
     * @return Form The form
     */
    private function createDeleteForm(Character $character)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('characters_delete', array('id' => $character->getId())))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Deletes a Character entity.
     *
     * @Route("/{id}/sleep", name="characters_sleep")
     * @Method("GET|POST")
     * @Template()
     * @Security("request.isMethodSafe() or is_granted('CHARACTER_EDIT', character) or has_role('ROLE_ADMIN')")
     *
     * @param Character $character
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function sleepAction(Character $character, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $sleepForm = $this->createForm(
            new SleepType($this->container->getParameter('bonus_spells')),
            $character, array('em' => $em)
        );

        $sleepForm->handleRequest($request);
        if ($sleepForm->isValid()) {
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

        return array(
            'form' => $sleepForm->createView()
        );
    }

    /**
     * View and change a character's hit points.
     *
     * @Route("/{id}/hitpoints", name="characters_hitpoints")
     * @Method("GET|PUT")
     * @Template()
     * @Security("request.isMethodSafe() or is_granted('CHARACTER_EDIT', character) or has_role('ROLE_ADMIN')")
     *
     * @param Character $character
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function hitPointsAction(Character $character, Request $request)
    {
        $hpForm = $this->createForm(
            new ChangeHpType(),
            $character,
            array(
                'method' => 'PUT',
                'action' => $this->generateUrl('characters_hitpoints', array('id' => $character->getId())),
            )
        );

        $hpForm->handleRequest($request);
        if ($hpForm->isValid()) {
            $character->changeHp($hpForm->get('hp_mod')->getData());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('characters_show', array('id' => $character->getId())));
        }

        return array('character' => $character, 'form' => $hpForm->createView());
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
     * @Method("GET|PUT")
     * @Template()
     * @Security("request.isMethodSafe() or is_granted('CHARACTER_EDIT', character) or has_role('ROLE_ADMIN')")
     *
     * @param Character $character
     * @param $type
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function notesAction(Character $character, $type, Request $request)
    {
        $form = $this->createForm(
            new NotesType(),
            $character,
            array(
                'type'   => $type,
                'method' => 'PUT',
                'action' => $this->generateUrl(
                    'characters_notes',
                    array('id' => $character->getId(), 'type' => $type)),
            )
        );
        $form->add('submit', 'submit', array('label' => 'Save notes'));

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            switch($type) {
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
     * @Method("GET|PUT")
     * @Template()
     * @Security("request.isMethodSafe() or is_granted('CHARACTER_EDIT', character) or has_role('ROLE_ADMIN')")
     *
     * @param Character $character
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function learnSpellAction(Character $character, Request $request)
    {
        if (!$character->canLearnSpells()) {
            throw new NotFoundHttpException('This character cannot learn spells');
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(
            new LearnSpellType($em),
            $character,
            array(
                'method' => 'PUT',
                'action' => $this->generateUrl(
                    'characters_learn_spell',
                    array('id' => $character->getId())
                ),
            )
        );
        $form->add('submit', 'submit', array('label' => 'Learn Spell'));

        $form->handleRequest($request);
        if ($form->isValid()) {
            /** @var ClassSpell $spell */
            $spell = $form->get('spell')->getData();
            $character->addExtraSpell($spell);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', $spell . ' learned  successfully');
            return $this->redirect($this->generateUrl('characters_show', array('id' => $character->getId())));
        }

        return array('form' => $form->createView());
    }
}

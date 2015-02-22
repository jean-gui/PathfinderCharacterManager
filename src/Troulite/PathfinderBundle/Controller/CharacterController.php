<?php

namespace Troulite\PathfinderBundle\Controller;

use Doctrine\ORM\EntityManager;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Troulite\PathfinderBundle\Entity\Character;
use Troulite\PathfinderBundle\Entity\CharacterClassPower;
use Troulite\PathfinderBundle\Entity\CharacterFeat;
use Troulite\PathfinderBundle\Entity\ClassSpell;
use Troulite\PathfinderBundle\Entity\Level;
use Troulite\PathfinderBundle\Entity\PowerEffect;
use Troulite\PathfinderBundle\Entity\SpellEffect;
use Troulite\PathfinderBundle\Form\BaseCharacterType;
use Troulite\PathfinderBundle\Form\CastSpellsType;
use Troulite\PathfinderBundle\Form\ChangeHpType;
use Troulite\PathfinderBundle\Form\LevelUpFlow;
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
     * @param Character $entity The entity
     * @return Form The form
     */
    private function createCreateForm(Character $entity)
    {
        $form = $this->createForm(
            new BaseCharacterType($this->container->getParameter('character_advancement')),
            $entity,
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
        $entity = new Character();
        $form = $this->createCreateForm($entity);

        if($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                /** @var $token TokenInterface */
                $token = $this->get('security.context')->getToken();
                $entity->setUser($token->getUser());

                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('characters_levelup', array('id' => $entity->getId())));
            }
        }

        $ability_scores = $this->container->getParameter('ability_scores');

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'ability_scores' => $ability_scores
        );
    }

    /**
     * Finds and displays a Character entity.
     *
     * @Route("/{id}", name="characters_show")
     * @Template()
     *
     * @param Character $entity
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function showAction(Character $entity, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $this->get('troulite_pathfinder.character_bonuses')->applyAll($entity);

        $needActivationFeats = array();
        $passiveFeats = array();
        $otherFeats = array();
        foreach ($entity->getFeats() as $spellEffect) {
            if (!$spellEffect->getFeat()->hasEffects()) {
                $otherFeats[] = $spellEffect;
            } elseif (!$spellEffect->getFeat()->isPassive() || $spellEffect->getFeat()->hasExternalConditions()) {
                $needActivationFeats[] = $spellEffect;
            } else {
                $passiveFeats[] = $spellEffect;
            }
        }

        $needActivationClassPowers = array();
        $passiveClassPowers        = array();
        $otherClassPowers       = array();
        foreach ($entity->getClassPowers() as $classPower) {
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
        foreach ($entity->getSpellEffects() as $spellEffect) {
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
        foreach ($entity->getPowerEffects() as $powerEffect) {
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
        $powersActivationForm->handleRequest($request);

        if ($powersActivationForm->isValid()) {
            if (array_key_exists('class_powers', $request->request->get('classpoweractivation'))) {
                foreach ($request->request->get('classpoweractivation')['class_powers'] as $key => $value) {
                    /** @var $ccp CharacterClassPower */
                    $ccp = $powersActivationForm->get('class_powers')->get($key)->getData();

                    if (array_key_exists('cancel', $value) && $value['cancel']) {
                        foreach ($entity->getParty()->getCharacters() as $target) {
                            foreach ($target->getPowerEffects() as $powerEffect) {
                                if ($powerEffect->getCaster() === $entity && $powerEffect->getPower() === $ccp->getClassPower()) {
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
                                foreach ($entity->getParty()->getCharacters() as $target) {
                                    $target->addPowerEffect(
                                        (new PowerEffect())
                                            ->setPower($ccp->getClassPower())
                                            ->setCaster($entity)
                                            ->setCasterLevel($entity->getLevel($ccp->getClassPower()->getClass()))
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
                                            ->setCaster($entity)
                                            ->setCasterLevel($entity->getLevel($ccp->getClassPower()->getClass()))
                                    );
                                }
                                break;
                        }
                    }
                }
            }

            $em->flush();

            return $this->redirect($this->generateUrl('characters_show', array('id' => $entity->getId())));
        }

        $skills = $em->getRepository('TroulitePathfinderBundle:Skill')->findAll();

        return array(
            'entity' => $entity,
            'powers_activation_form' => $powersActivationForm->createView(),
            'skills' => $skills,
            'passive_feats' => $passiveFeats,
            'passive_class_powers' => $passiveClassPowers,
            'other_feats' => $otherFeats,
            'other_class_powers' => $otherClassPowers,
            'passive_spell_effects' => $passiveSpellEffects,
            'other_spell_effects' => $otherSpellEffects,
            'passive_power_effects' => $passivePowerEffects,
            'other_power_effects'   => $otherPowerEffects
        );
    }

    /**
     * Display a character's equipment
     *
     * @Route("/{id}/equipment", name="character_equipment")
     * @Template()
     *
     * @param Character $character
     *
     * @return array
     */
    public function showEquipmentAction(Character $character)
    {
        $this->get('troulite_pathfinder.character_bonuses')->applyAll($character);

        return array("entity" => $character);
    }

    /**
     * Show character spell casting form
     *
     * @Route("/{id}/spells", name="character_spells")
     * @Template()
     *
     * @param Character $entity
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function showCharacterSpellsAction(Character $entity, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $this->get('troulite_pathfinder.character_bonuses')->applyAll($entity);

        $castSpellsForm = $this->createForm(new CastSpellsType($this->container->getParameter('bonus_spells')),
            $entity);
        $castSpellsForm->handleRequest($request);
        if ($castSpellsForm->isValid()) {
            /** @var $f Form */
            foreach ($castSpellsForm->all() as $f) {
                if ($f->getName() === 'Cast') {
                    continue;
                }

                $spell = null;

                if ($f->getConfig()->getOption('spell')) { // Prepared Spell
                    $spell = $f->getConfig()->getOption('spell');
                } elseif ($f->getData()['spell']) { // Unprepared Spell
                    /** @var $classSpell ClassSpell */
                    $classSpell = $f->getData()['spell'];
                    $spell      = $classSpell->getSpell();
                }
                $class  = $f->getConfig()->getOption('class');
                $target = $f->getData()['targets'];

                if ($target === null || $spell === null) {
                    continue;
                }

                switch ($target) {
                    case 'other':
                        $this->get('troulite_pathfinder.spell_casting')->cast($entity, $spell, $class);
                        break;
                    case 'allies':
                        $this->get('troulite_pathfinder.spell_casting')->cast(
                            $entity,
                            $spell,
                            $class,
                            $entity->getParty()->getCharacters()
                        );
                        break;
                    default:
                        $target = $em->getRepository('TroulitePathfinderBundle:Character')->find($target);
                        if ($target) {
                            $this->get('troulite_pathfinder.spell_casting')->cast($entity, $spell, $class,
                                array($target));
                        }
                        break;
                }

                return $this->redirect($this->generateUrl('characters_show', array('id' => $entity->getId())));
            }
        }

        $uncastSpellsForm = $this->createForm(new UncastSpellsType(), $entity);
        $uncastSpellsForm->handleRequest($request);
        if ($uncastSpellsForm->isValid()) {
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

            return $this->redirect($this->generateUrl('characters_show', array('id' => $entity->getId())));
        }

        return array(
            'entity'                 => $entity,
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
     *
     * @param Character $character
     *
*@return array
     */
    public function editAction(Character $character)
    {
        $editForm = $this->createEditForm($character);
        $deleteForm = $this->createDeleteForm($character->getId());

        return array(
            'entity' => $character,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Character entity.
     *
     * @param Character $entity The entity
     *
     * @return Form The form
     */
    private function createEditForm(Character $entity)
    {
        $form = $this->createForm(
            new BaseCharacterType($this->container->getParameter('character_advancement')),
            $entity,
            array(
                'action' => $this->generateUrl('characters_update', array('id' => $entity->getId())),
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
     *
     * @param Request $request
     * @param Character $character
     *
     * @return array|RedirectResponse
     */
    public function updateAction(Request $request, Character $character)
    {
        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($character->getId());
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
     * Edits an existing Character entity.
     *
     * @Route("/{id}/levelup", name="characters_levelup")
     * @Template()
     *
     * @param Character $character
     * @return array|RedirectResponse
     */
    public function levelUpAction(Character $character)
    {
        $level = new Level();
        $level->setClassDefinition($character->getFavoredClass());
        $character->addLevel($level);
        $this->get('troulite_pathfinder.character_bonuses')->applyAll($character);

        /** @var $flow LevelUpFlow */
        $flow = $this->get('troulite_pathfinder.form.flow.levelup');
        $flow->bind($level);

        // Add class powers if they were not already added through a form
        if ($level->getClassDefinition()) {
            foreach ($level->getClassDefinition()->getPowers($character->getLevel($level->getClassDefinition())) as $power) {
                $alreadyAdded = false;
                foreach ($level->getClassPowers() as $classPower) {
                    if ($classPower->getClassPower() === $power) {
                        $alreadyAdded = true;
                        break;
                    }
                }
                if (!$alreadyAdded) {
                    $level->addClassPower((new CharacterClassPower())->setClassPower($power));
                }
            }
        }

        // Cleanup empty feats that may have been added by the form
        foreach ($level->getFeats() as $feat) {
            if ($feat === null || $feat->getFeat() === null) {
                $level->removeFeat($feat);
            }
        }

        // form of the current step
        $form = $flow->createForm();
        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                // form for the next step
                $form = $flow->createForm();
            } else {
                // flow finished

                // Cleanup empty skills as well
                foreach ($level->getSkills() as $levelSkill) {
                    if ($levelSkill->getValue() === 0) {
                        $level->removeSkill($levelSkill);
                    }
                }

                // Max HP for first level
                if ($character->getLevel() === 1) {
                    $character->getLevels()[0]->setHpRoll($character->getLevels()[0]->getClassDefinition()->getHpDice());
                }

                /** @var $em EntityManager */
                $em = $this->getDoctrine()->getManager();

                // Add fixed extra feats granted by this level
                foreach ($level->getClassPowers() as $power) {
                    $effects = $power->getClassPower()->getEffects();
                    if (
                        $power->getClassPower()->hasEffects() &&
                        array_key_exists('feat', $effects) &&
                        $effects['feat']['type'] !== 'oneof'
                    ) {
                        $feat = $em->getRepository('TroulitePathfinderBundle:Feat')
                            ->findOneBy(array('name' => $effects['feat']['value']));
                        if ($feat) {
                            $level->addFeat((new CharacterFeat())->setFeat($feat));
                        }
                    }
                }

                $em->persist($level);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    $character . ' is now level ' . $character->getLevel()
                );

                return $this->redirect($this->generateUrl('characters_show', array('id' => $character->getId())));
            }
        }

        return array(
            'form' => $form->createView(),
            'flow' => $flow,
            'entity' => $character
        );
    }

    /**
     * Deletes a Character entity.
     *
     * @Route("/{id}", name="characters_delete")
     * @Method("DELETE")
     *
     * @param Request $request
     * @param Character $character
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Character $character)
    {
        $form = $this->createDeleteForm($character->getId());
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
     * @param mixed $id The entity id
     *
     * @return Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('characters_delete', array('id' => $id)))
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
     *
     * @param Character $entity
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function sleepAction(Character $entity, Request $request)
    {
        $this->get('troulite_pathfinder.character_bonuses')->applyAll($entity);

        /** @var $em EntityManager */
        $em = $this->get('doctrine.orm.entity_manager');
        $sleepForm = $this->createForm(
            new SleepType($this->container->getParameter('bonus_spells')),
            $entity, array('em' => $em)
        );

        $sleepForm->handleRequest($request);
        if ($sleepForm->isValid()) {
            $entity->setNonPreparedCastSpellsCount(null);
            foreach ($entity->getPreparedSpells() as $preparedSpell) {
                $preparedSpell->setAlreaydCast(false);
            }
            $em->flush();

            return $this->redirect($this->generateUrl('characters_show', array('id' => $entity->getId())));
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
     *
     * @param Character $character
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function hitPointsAction(Character $character, Request $request)
    {
        $this->get('troulite_pathfinder.character_bonuses')->applyAll($character);

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
            /** @var EntityManager $em */
            $em = $this->get('doctrine.orm.entity_manager');
            $em->flush();

            return $this->redirect($this->generateUrl('characters_show', array('id' => $character->getId())));
        }

        return array('character' => $character, 'form' => $hpForm->createView());
    }
}

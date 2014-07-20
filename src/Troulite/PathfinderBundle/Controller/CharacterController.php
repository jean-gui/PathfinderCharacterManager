<?php

namespace Troulite\PathfinderBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Troulite\PathfinderBundle\Entity\BaseCharacter as BaseCharacter;
use Troulite\PathfinderBundle\Entity\CharacterFeat;
use Troulite\PathfinderBundle\Entity\Level;
use Troulite\PathfinderBundle\Form\BaseCharacterType;
use Troulite\PathfinderBundle\Form\FeatsActivationType;
use Troulite\PathfinderBundle\Form\LevelUpFlow;
use Troulite\PathfinderBundle\Model\Character;

/**
 * BaseCharacter controller.
 *
 * @Route("/characters")
 */
class CharacterController extends Controller
{

    /**
     * Lists all BaseCharacter entities.
     *
     * @Route("/", name="characters")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TroulitePathfinderBundle:BaseCharacter')->findAll();

        $characters = new ArrayCollection();
        foreach ($entities as $entity) {
            $characters->add(new Character($entity));
        }

        return array(
            'entities' => $characters,
        );
    }

    /**
     * Creates a form to create a BaseCharacter entity.
     *
     * @param BaseCharacter $entity The entity
     * @return Form The form
     */
    private function createCreateForm(BaseCharacter $entity)
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
     * Displays a form to create a new BaseCharacter entity.
     *
     * @Route("/new", name="characters_new")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function newAction(Request $request)
    {
        $entity = new BaseCharacter();
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
     * Finds and displays a BaseCharacter entity.
     *
     * @Route("/{id}", name="characters_show")
     * @Template()
     */
    public function showAction(BaseCharacter $entity, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $character = new Character($entity);
        $this->get('troulite_pathfinder.character_bonuses')->applyAll($character);

        /** @var $needActivationFeats CharacterFeat[] */
        /** @var $passiveFeats CharacterFeat[] */
        /** @noinspection PhpUnusedParameterInspection */
        list($needActivationFeats, $passiveFeats) = $character->getFeats()->partition(
            function ($key, CharacterFeat $feat) {
                return !$feat->getFeat()->isPassive() || $feat->getFeat()->hasExternalConditions();
            }
        );

        $featsActivationForm = $this->createForm(new FeatsActivationType());
        $featsActivationForm->get('feats')->setData($needActivationFeats);
        $featsActivationForm->handleRequest($request);

        if ($featsActivationForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('characters_show', array('id' => $entity->getId())));
        }

        $skills = $em->getRepository('TroulitePathfinderBundle:Skill')->findAll();

        return array(
            'entity' => $character,
            'feats_activation_form' => $featsActivationForm->createView(),
            'skills' => $skills,
            'passive_feats' => $passiveFeats
        );
    }

    /**
     * Displays a form to edit an existing BaseCharacter entity.
     *
     * @Route("/{id}/edit", name="characters_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TroulitePathfinderBundle:BaseCharacter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BaseCharacter entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a BaseCharacter entity.
     *
     * @param BaseCharacter $entity The entity
     *
     * @return Form The form
     */
    private function createEditForm(BaseCharacter $entity)
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
     * Edits an existing BaseCharacter entity.
     *
     * @Route("/{id}/update", name="characters_update")
     * @Method("PUT")
     * @Template("TroulitePathfinderBundle:Character:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TroulitePathfinderBundle:BaseCharacter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BaseCharacter entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Update successful');

            return $this->redirect($this->generateUrl('characters_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing BaseCharacter entity.
     *
     * @Route("/{id}/levelup", name="characters_levelup")
     * @Template()
     */
    public function levelUpAction(BaseCharacter $entity)
    {
        $level = new Level();
        $entity->addLevel($level);
        $character = new Character($entity);
        $this->get('troulite_pathfinder.character_bonuses')->applyAll($character);

        /** @var $flow LevelUpFlow */
        $flow = $this->get('troulite_pathfinder.form.flow.levelup');
        $flow->bind($level);

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
                    $entity->getLevels()[0]->setHpRoll($entity->getLevels()[0]->getClassDefinition()->getHpDice());
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($level);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    $entity . ' is now level ' . $character->getLevel()
                );

                return $this->redirect($this->generateUrl('characters_show', array('id' => $entity->getId())));
            }
        }

        return array(
            'form' => $form->createView(),
            'flow' => $flow,
            'entity' => $character
        );
    }

    /**
     * Deletes a BaseCharacter entity.
     *
     * @Route("/{id}", name="characters_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TroulitePathfinderBundle:BaseCharacter')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BaseCharacter entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('characters'));
    }

    /**
     * Creates a form to delete a BaseCharacter entity by id.
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
}

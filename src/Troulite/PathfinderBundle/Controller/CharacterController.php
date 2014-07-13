<?php

namespace Troulite\PathfinderBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Troulite\PathfinderBundle\Entity\BaseCharacter as BaseCharacter;
use Troulite\PathfinderBundle\Entity\Level;
use Troulite\PathfinderBundle\Form\BaseCharacterType;
use Troulite\PathfinderBundle\Form\FeatsActivationType;
use Troulite\PathfinderBundle\Form\LevelType;
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
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(BaseCharacter $entity)
    {
        $form = $this->createForm(
            new BaseCharacterType(),
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
        $firstLevel = new Level();
        $firstLevel->setLevel(1);
        $entity->addLevel($firstLevel);
        $form = $this->createCreateForm($entity);

        if($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $entity->setUser($this->get('security.context')->getToken()->getUser());
                $entity->getLevels()[0]->setLevel(1);
                // Max HP for first level
                $entity->getLevels()[0]->setHpRoll($entity->getLevels()[0]->getClassDefinition()->getHpDice());

                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('characters_show', array('id' => $entity->getId())));
            }
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
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
        $character = new Character($entity);
        $this->get('troulite_pathfinder.character_bonuses')->applyAll($character);

        $em = $this->getDoctrine()->getManager();

        $featsActivationForm = $this->createForm(new FeatsActivationType(), $entity);
        $featsActivationForm->handleRequest($request);

        if ($featsActivationForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('characters_show', array('id' => $entity->getId())));
        }

        $skills = $em->getRepository('TroulitePathfinderBundle:Skill')->findAll();

        return array(
            'entity' => $character,
            'feats_activation_form' => $featsActivationForm->createView(),
            'skills' => $skills
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
     * @param Character $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(BaseCharacter $entity)
    {
        $form = $this->createForm(
            new BaseCharacterType(),
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
    public function levelUpAction(BaseCharacter $entity, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $currentLevel = $entity->getLevels()->count() + 1;
        $level = new Level();
        $level->setLevel($currentLevel);
        $entity->addLevel($level);

        $form = $this->createForm(
            new LevelType(),
            $level
        );
        $form->add('submit', 'submit', array('label' => 'Level Up'));

        if($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $entity . ' is now level ' . $level->getLevel());

                //return $this->redirect($this->generateUrl('characters_show', array('id' => $entity->getId())));
            }
        }

        return array('form' => $form->createView());
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
     * @return \Symfony\Component\Form\Form The form
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

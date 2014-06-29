<?php

namespace Troulite\PathfinderBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Troulite\PathfinderBundle\Entity\CharacterFeat;
use Troulite\PathfinderBundle\Form\CharacterFeatType;

/**
 * CharacterFeat controller.
 *
 * @Route("/characterfeats")
 */
class CharacterFeatController extends Controller
{

    /**
     * Lists all CharacterFeat entities.
     *
     * @Route("/", name="characterfeats")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TroulitePathfinderBundle:CharacterFeat')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new CharacterFeat entity.
     *
     * @Route("/", name="characterfeats_create")
     * @Method("POST")
     * @Template("TroulitePathfinderBundle:CharacterFeat:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new CharacterFeat();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('characterfeats_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a CharacterFeat entity.
     *
     * @param CharacterFeat $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CharacterFeat $entity)
    {
        $form = $this->createForm(
            new CharacterFeatType(),
            $entity,
            array(
                'action' => $this->generateUrl('characterfeats_create'),
                'method' => 'POST',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CharacterFeat entity.
     *
     * @Route("/new", name="characterfeats_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CharacterFeat();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a CharacterFeat entity.
     *
     * @Route("/{id}", name="characterfeats_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TroulitePathfinderBundle:CharacterFeat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CharacterFeat entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CharacterFeat entity.
     *
     * @Route("/{id}/edit", name="characterfeats_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TroulitePathfinderBundle:CharacterFeat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CharacterFeat entity.');
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
     * Creates a form to edit a CharacterFeat entity.
     *
     * @param CharacterFeat $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(CharacterFeat $entity)
    {
        $form = $this->createForm(
            new CharacterFeatType(),
            $entity,
            array(
                'action' => $this->generateUrl('characterfeats_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing CharacterFeat entity.
     *
     * @Route("/{id}", name="characterfeats_update")
     * @Method("PUT")
     * @Template("TroulitePathfinderBundle:CharacterFeat:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TroulitePathfinderBundle:CharacterFeat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CharacterFeat entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('characterfeats_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a CharacterFeat entity.
     *
     * @Route("/{id}", name="characterfeats_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TroulitePathfinderBundle:CharacterFeat')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CharacterFeat entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('characterfeats'));
    }

    /**
     * Creates a form to delete a CharacterFeat entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('characterfeats_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}

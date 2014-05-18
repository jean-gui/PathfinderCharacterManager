<?php

namespace Troulite\PathfinderBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Troulite\PathfinderBundle\Entity\Race;
use Troulite\PathfinderBundle\Form\RaceType;

/**
 * Race controller.
 *
 * @Route("/races")
 */
class RaceController extends Controller
{

    /**
     * Lists all Race entities.
     *
     * @Route("/", name="races")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TroulitePathfinderBundle:Race')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Race entity.
     *
     * @Route("/", name="races_create")
     * @Method("POST")
     * @Template("TroulitePathfinderBundle:Race:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Race();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('races_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Race entity.
     *
     * @param Race $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Race $entity)
    {
        $form = $this->createForm(
            new RaceType(),
            $entity,
            array(
                'action' => $this->generateUrl('races_create'),
                'method' => 'POST',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Race entity.
     *
     * @Route("/new", name="races_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Race();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Race entity.
     *
     * @Route("/{id}", name="races_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TroulitePathfinderBundle:Race')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Race entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Race entity.
     *
     * @Route("/{id}/edit", name="races_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TroulitePathfinderBundle:Race')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Race entity.');
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
     * Creates a form to edit a Race entity.
     *
     * @param Race $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Race $entity)
    {
        $form = $this->createForm(
            new RaceType(),
            $entity,
            array(
                'action' => $this->generateUrl('races_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Race entity.
     *
     * @Route("/{id}", name="races_update")
     * @Method("PUT")
     * @Template("TroulitePathfinderBundle:Race:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TroulitePathfinderBundle:Race')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Race entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('races_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Race entity.
     *
     * @Route("/{id}", name="races_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TroulitePathfinderBundle:Race')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Race entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('races'));
    }

    /**
     * Creates a form to delete a Race entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('races_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}

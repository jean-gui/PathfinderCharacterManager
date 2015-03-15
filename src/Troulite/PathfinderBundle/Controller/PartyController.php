<?php

namespace Troulite\PathfinderBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Troulite\PathfinderBundle\Entity\Party;
use Troulite\PathfinderBundle\Form\PartyType;

/**
 * Party controller.
 *
 * @Route("/parties")
 */
class PartyController extends Controller
{

    /**
     * Lists all Party entities.
     *
     * @Route("/", name="parties")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TroulitePathfinderBundle:Party')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Party entity.
     *
     * @Route("/", name="parties_create")
     * @Method("POST")
     * @Template("TroulitePathfinderBundle:Party:new.html.twig")
     *
     * @param Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $entity = new Party();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('parties_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Party entity.
     *
     * @param Party $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Party $entity)
    {
        $form = $this->createForm(
            new PartyType(),
            $entity,
            array(
                'action' => $this->generateUrl('parties_create'),
                'method' => 'POST',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Party entity.
     *
     * @Route("/new", name="parties_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Party();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Party entity.
     *
     * @Route("/{id}", name="parties_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TroulitePathfinderBundle:Party')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Party entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Party entity.
     *
     * @Route("/{id}/edit", name="parties_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TroulitePathfinderBundle:Party')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Party entity.');
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
     * Creates a form to edit a Party entity.
     *
     * @param Party $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Party $entity)
    {
        $form = $this->createForm(
            new PartyType(),
            $entity,
            array(
                'action' => $this->generateUrl('parties_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Party entity.
     *
     * @Route("/{id}", name="parties_update")
     * @Method("PUT")
     * @Template("TroulitePathfinderBundle:Party:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TroulitePathfinderBundle:Party')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Party entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('parties_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Party entity.
     *
     * @Route("/{id}", name="parties_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TroulitePathfinderBundle:Party')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Party entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('parties'));
    }

    /**
     * Creates a form to delete a Party entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('parties_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}

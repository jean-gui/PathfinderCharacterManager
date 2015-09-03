<?php

namespace Troulite\PathfinderBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Troulite\PathfinderBundle\Entity\SubClass;
use Troulite\PathfinderBundle\Form\SubClassType;

/**
 * SubClass controller.
 *
 * @Route("/subclasses")
 */
class SubClassController extends Controller
{

    /**
     * Lists all SubClass entities.
     *
     * @Route("/", name="subclasses")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TroulitePathfinderBundle:SubClass')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new SubClass entity.
     *
     * @Route("/", name="subclasses_create")
     * @Method("POST")
     * @Template("TroulitePathfinderBundle:SubClass:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new SubClass();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('subclasses_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a SubClass entity.
     *
     * @param SubClass $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SubClass $entity)
    {
        $form = $this->createForm(new SubClassType(), $entity, array(
            'action' => $this->generateUrl('subclasses_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SubClass entity.
     *
     * @Route("/new", name="subclasses_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SubClass();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a SubClass entity.
     *
     * @Route("/{id}", name="subclasses_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TroulitePathfinderBundle:SubClass')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubClass entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SubClass entity.
     *
     * @Route("/{id}/edit", name="subclasses_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TroulitePathfinderBundle:SubClass')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubClass entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a SubClass entity.
    *
    * @param SubClass $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SubClass $entity)
    {
        $form = $this->createForm(new SubClassType(), $entity, array(
            'action' => $this->generateUrl('subclasses_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing SubClass entity.
     *
     * @Route("/{id}", name="subclasses_update")
     * @Method("PUT")
     * @Template("TroulitePathfinderBundle:SubClass:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TroulitePathfinderBundle:SubClass')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubClass entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('subclasses_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a SubClass entity.
     *
     * @Route("/{id}", name="subclasses_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TroulitePathfinderBundle:SubClass')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SubClass entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('subclasses'));
    }

    /**
     * Creates a form to delete a SubClass entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('subclasses_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

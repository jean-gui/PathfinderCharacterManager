<?php

namespace Troulite\PathfinderBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Troulite\PathfinderBundle\Entity\ClassDefinition;
use Troulite\PathfinderBundle\Form\ClassDefinitionType;

/**
 * ClassDefinition controller.
 *
 * @Route("/classes")
 */
class ClassDefinitionController extends Controller
{

    /**
     * Lists all ClassDefinition entities.
     *
     * @Route("/", name="classes")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TroulitePathfinderBundle:ClassDefinition')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new ClassDefinition entity.
     *
     * @Route("/", name="classes_create")
     * @Method("POST")
     * @Template("TroulitePathfinderBundle:ClassDefinition:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ClassDefinition();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('classes_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a ClassDefinition entity.
     *
     * @param ClassDefinition $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ClassDefinition $entity)
    {
        $form = $this->createForm(
            new ClassDefinitionType(),
            $entity,
            array(
                'action' => $this->generateUrl('classes_create'),
                'method' => 'POST',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ClassDefinition entity.
     *
     * @Route("/new", name="classes_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ClassDefinition();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a ClassDefinition entity.
     *
     * @Route("/{id}", name="classes_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(ClassDefinition $classDefinition)
    {
        $deleteForm = $this->createDeleteForm($classDefinition->getId());

        return array(
            'entity' => $classDefinition,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ClassDefinition entity.
     *
     * @Route("/{id}/edit", name="classes_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TroulitePathfinderBundle:ClassDefinition')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ClassDefinition entity.');
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
     * Creates a form to edit a ClassDefinition entity.
     *
     * @param ClassDefinition $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(ClassDefinition $entity)
    {
        $form = $this->createForm(
            new ClassDefinitionType(),
            $entity,
            array(
                'action' => $this->generateUrl('classes_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing ClassDefinition entity.
     *
     * @Route("/{id}", name="classes_update")
     * @Method("PUT")
     * @Template("TroulitePathfinderBundle:ClassDefinition:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TroulitePathfinderBundle:ClassDefinition')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ClassDefinition entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('classes_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ClassDefinition entity.
     *
     * @Route("/{id}", name="classes_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TroulitePathfinderBundle:ClassDefinition')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ClassDefinition entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('classes'));
    }

    /**
     * Creates a form to delete a ClassDefinition entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('classes_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn-danger')))
            ->getForm();
    }
}

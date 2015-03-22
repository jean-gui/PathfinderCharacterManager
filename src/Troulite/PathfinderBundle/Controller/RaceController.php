<?php

namespace Troulite\PathfinderBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
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

            return $this->redirect($this->generateUrl('races_show', array('race' => $entity->getId())));
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
     * @return Form The form
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
     *
     * @param Race $race
     *
     * @return array
     */
    public function showAction(Race $race)
    {
        $deleteForm = $this->createDeleteForm($race);

        return array(
            'entity' => $race,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Race entity.
     *
     * @Route("/{id}/edit", name="races_edit")
     * @Method("GET")
     * @Template()
     *
     * @param Race $race
     *
     * @return array
     */
    public function editAction(Race $race)
    {
        $editForm = $this->createEditForm($race);
        $deleteForm = $this->createDeleteForm($race);

        return array(
            'entity' => $race,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Race entity.
     *
     * @param Race $race The entity
     *
     * @return Form The form
     */
    private function createEditForm(Race $race)
    {
        $form = $this->createForm(
            new RaceType(),
            $race,
            array(
                'action' => $this->generateUrl('races_update', array('race' => $race->getId())),
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
     *
     * @param Request $request
     * @param Race $race
     *
     * @return array|RedirectResponse
     */
    public function updateAction(Request $request, Race $race)
    {
        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($race);
        $editForm = $this->createEditForm($race);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('races_edit', array('race' => $race)));
        }

        return array(
            'entity' => $race,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Race entity.
     *
     * @Route("/{id}", name="races_delete")
     * @Method("DELETE")
     *
     * @param Request $request
     * @param Race $race
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Race $race)
    {
        $form = $this->createDeleteForm($race);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($race);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('races'));
    }

    /**
     * Creates a form to delete a Race entity by id.
     *
     * @param Race $race The entity id
     *
     * @return Form The form
     */
    private function createDeleteForm(Race $race)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('races_delete', array('race' => $race->getId())))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn-danger')))
            ->getForm();
    }
}

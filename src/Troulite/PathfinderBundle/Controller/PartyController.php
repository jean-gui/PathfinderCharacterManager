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

use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     * @Secure(roles="ROLE_USER")
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function createAction(Request $request)
    {
        $party = new Party();
        $form = $this->createCreateForm($party);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($party);
            $em->flush();

            return $this->redirect($this->generateUrl('parties_show', array('id' => $party->getId())));
        }

        return array(
            'entity' => $party,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Party entity.
     *
     * @param Party $party The entity
     *
     * @return Form The form
     */
    private function createCreateForm(Party $party)
    {
        $form = $this->createForm(
            new PartyType(),
            $party,
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
     * @Secure(roles="ROLE_USER")
     */
    public function newAction()
    {
        $party = new Party();
        $form = $this->createCreateForm($party);

        return array(
            'entity' => $party,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Party entity.
     *
     * @Route("/{id}", name="parties_show")
     * @Method("GET")
     * @Template()
     * @Security("request.isMethodSafe() or is_granted('PARTY_EDIT', party) or has_role('ROLE_ADMIN')")
     *
     * @param Party $party
     *
     * @return array
     */
    public function showAction(Party $party)
    {
        $deleteForm = $this->createDeleteForm($party);

        return array(
            'entity' => $party,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Party entity.
     *
     * @Route("/{id}/edit", name="parties_edit")
     * @Method("GET")
     * @Template()
     * @Security("is_granted('PARTY_EDIT', party) or has_role('ROLE_ADMIN')")
     *
     * @param Party $party
     *
     * @return array
     */
    public function editAction(Party $party)
    {
        $editForm = $this->createEditForm($party);
        $deleteForm = $this->createDeleteForm($party);

        return array(
            'entity' => $party,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Party entity.
     *
     * @param Party $party The entity
     *
     * @return Form The form
     */
    private function createEditForm(Party $party)
    {
        $form = $this->createForm(
            new PartyType(),
            $party,
            array(
                'action' => $this->generateUrl('parties_update', array('id' => $party->getId())),
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
     * @Security("is_granted('PARTY_EDIT', party) or has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param Party $party
     *
     * @return array|RedirectResponse
     */
    public function updateAction(Request $request, Party $party)
    {
        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($party);
        $editForm = $this->createEditForm($party);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('parties_edit', array('id' => $party)));
        }

        return array(
            'entity' => $party,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Party entity.
     *
     * @Route("/{id}", name="parties_delete")
     * @Method("DELETE")
     * @Security("is_granted('PARTY_EDIT', party) or has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param Party $party
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Party $party)
    {
        $form = $this->createDeleteForm($party);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($party);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('parties'));
    }

    /**
     * Creates a form to delete a Party entity by id.
     *
     * @param Party $party The party
     *
     * @return Form The form
     */
    private function createDeleteForm(Party $party)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('parties_delete', array('id' => $party->getId())))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * @param Party $party
     *
     * @Route("/{id}/dm", name="party_dm")
     * @Template()
     * @Method("GET")
     * @Security("request.isMethodSafe() or is_granted('PARTY_EDIT', party.getDungeonMaster()) or has_role('ROLE_ADMIN')")
     *
     * @return array
     */
    public function dungeonMasterAction(Party $party)
    {
        return array('entity' => $party);
    }
}

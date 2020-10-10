<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Party;
use App\Form\PartyType;

/**
 * Party controller.
 *
 * @Route("/parties")
 */
class PartyController extends AbstractController
{

    /**
     * Lists all Party entities.
     *
     * @Route("/", name="parties")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository(Party::class)->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a form to create a Party entity.
     *
     * @param Party $party The entity
     *
     * @return FormInterface The form
     */
    private function createCreateForm(Party $party)
    {
        $form = $this->createForm(
            PartyType::class,
            $party
        );

        $form->add('submit', SubmitType::class, array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Party entity.
     *
     * @Route("/new", name="parties_new")
     * @Template()
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function newAction(Request $request)
    {
        $party = new Party();
        $form = $this->createCreateForm($party);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($party);
            $em->flush();

            return $this->redirect($this->generateUrl('parties_show', ['id' => $party->getId()]));
        }

        return array(
            'entity' => $party,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Party entity.
     *
     * @Route("/{id}", name="parties_show", methods={"GET"})
     * @Template()
     * @Security("request.isMethodSafe() or is_granted('PARTY_EDIT', party) or is_granted('ROLE_ADMIN')")
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
     * @Template()
     * @Security("is_granted('PARTY_EDIT', party) or is_granted('ROLE_ADMIN')")
     *
     * @param Party $party
     *
     * @return array
     */
    public function editAction(Party $party)
    {
        $editForm = $this->createEditForm($party);

        return array(
            'entity' => $party,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Party entity.
     *
     * @param Party $party The entity
     *
     * @return FormInterface The form
     */
    private function createEditForm(Party $party)
    {
        $form = $this->createForm(
            PartyType::class,
            $party,
            array(
                'action' => $this->generateUrl('parties_update', array('id' => $party->getId())),
            )
        );

        $form->add('submit', SubmitType::class, array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Party entity.
     *
     * @Route("/{id}", name="parties_update", methods={"POST"})
     * @Template("party/edit.html.twig")
     * @Security("is_granted('PARTY_EDIT', party) or is_granted('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param Party $party
     *
     * @return array|RedirectResponse
     */
    public function updateAction(Request $request, Party $party)
    {
        $em = $this->getDoctrine()->getManager();

        $editForm = $this->createEditForm($party);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('parties_edit', array('id' => $party->getId())));
        }

        return array(
            'entity' => $party,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Party entity.
     *
     * @Route("/{id}", name="parties_delete", methods={"DELETE"})
     * @Security("is_granted('PARTY_EDIT', party) or is_granted('ROLE_ADMIN')")
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

        if ($form->isSubmitted() && $form->isValid()) {
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
     * @return FormInterface The form
     */
    private function createDeleteForm(Party $party)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('parties_delete', array('id' => $party->getId())))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Delete'))
            ->getForm();
    }
}

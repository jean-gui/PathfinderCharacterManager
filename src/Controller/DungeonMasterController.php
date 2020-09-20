<?php
namespace App\Controller;

use App\Entity\Party;
use App\Form\Conditions\PartyConditionsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Character controller.
 *
 * @Route("/parties")
 */
class DungeonMasterController extends AbstractController
{
    /**
     * @param Party   $party
     * @param Request $request
     *
     * @Route("/{id}/dm", name="party_dm")
     * @Security("request.isMethodSafe() or is_granted('DM_EDIT', party) or is_granted('ROLE_ADMIN')")
     *
     * @return RedirectResponse|Response
     */
    public function dungeonMasterAction(Party $party, Request $request)
    {
        $form = $this->createForm(
            PartyConditionsType::class,
            $party,
            array(
                'action' => $this->generateUrl('party_dm', array('id' => $party->getId())),
                'method' => 'PUT',
            )
        );
        $form->add('submit', SubmitType::class, array('label' => 'Update'));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'character_conditions.updated');

            return $this->redirectToRoute('party_dm', array('id' => $party->getId()));
        }

        return $this->render(
            'dungeon_master/dungeon_master.html.twig',
            ['entity' => $party, 'form' => $form->createView()]
        );
    }
}
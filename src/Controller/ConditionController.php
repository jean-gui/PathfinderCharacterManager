<?php

namespace App\Controller;

use App\Entity\Rules\Condition;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Condition controller.
 *
 * @Route("/conditions")
 */
class ConditionController extends AbstractController
{

    /**
     * Lists all Condition entities.
     *
     * @Route("/", name="conditions")
     *
     * @return Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(Condition::class)->findAll();

        return $this->render('condition/index.html.twig', ['entities' => $entities]);
    }

    /**
     * Finds and displays a Condition entity.
     *
     * @Route("/{id}", name="conditions_show")
     *
     * @param Condition $entity
     *
     * @return Response
     */
    public function showAction(Condition $entity)
    {
        return $this->render('condition/show.html.twig', ['entity' => $entity]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Rules\Race;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Race controller.
 *
 * @Route("/races")
 */
class RaceController extends AbstractController
{

    /**
     * Lists all Race entities.
     *
     * @Route("/", name="races")
     *
     * @return Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(Race::class)->findAll();

        return $this->render('race/index.html.twig', ['entities' => $entities]);
    }

    /**
     * Finds and displays a Race entity.
     *
     * @Route("/{id}", name="races_show")
     *
     * @param Race $race
     *
     * @return Response
     */
    public function showAction(Race $race)
    {
        return $this->render('race/show.html.twig', ['entity' => $race]);
    }
}

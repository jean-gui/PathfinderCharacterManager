<?php

namespace App\Controller;

use App\Entity\Rules\Feat;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Feat controller.
 *
 * @Route("/feats")
 */
class FeatController extends AbstractController
{

    /**
     * Lists all Feat entities.
     *
     * @Route("/", name="feats")
     *
     * @return Response
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('SELECT f FROM Rules:Feat f LEFT JOIN f.translations t ORDER BY t.name');

        $query->enableResultCache(3600);

        $entities = $query->getResult();

        return $this->render('feat/index.html.twig', ['entities' => $entities]);
    }

    /**
     * Finds and displays a Feat entity.
     *
     * @Route("/{id}", name="feats_show", requirements={"id": "\d+"})
     * @Template()
     *
     * @param Feat $feat
     *
     * @return Response
     */
    public function showAction(Feat $feat)
    {
        return $this->render('feat/show.html.twig', ['entity' => $feat]);
    }
}

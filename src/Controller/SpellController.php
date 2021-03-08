<?php

namespace App\Controller;

use App\Entity\Rules\Spell;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Spell controller.
 *
 * @Route("/spells")
 */
class SpellController extends AbstractController
{

    /**
     * Lists all Spell entities.
     *
     * @Route("/", name="spells")
     *
     * @return Response
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT s, cs, c FROM Rules:Spell s LEFT JOIN s.classes cs LEFT JOIN cs.class c LEFT JOIN s.translations t ORDER BY t.name'
        );

        $query->enableResultCache(3600);

        $entities = $query->getResult();

        return $this->render('spell/index.html.twig', ['entities' => $entities]);
    }

    /**
     * Finds and displays a Spell entity.
     *
     * @Route("/{id}", name="spells_show")
     *
     * @param Spell $spell
     *
     * @return Response
     */
    public function showAction(Spell $spell)
    {
        return $this->render('spell/show.html.twig', ['entity' => $spell]);
    }
}

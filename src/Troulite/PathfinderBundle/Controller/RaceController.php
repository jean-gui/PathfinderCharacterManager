<?php

namespace Troulite\PathfinderBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Troulite\PathfinderBundle\Entity\Race;

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
        return array(
            'entity' => $race,
        );
    }
}

<?php

namespace Troulite\PathfinderBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Troulite\PathfinderBundle\Entity\Feat;

/**
 * Feat controller.
 *
 * @Route("/feats")
 */
class FeatController extends Controller
{

    /**
     * Lists all Feat entities.
     *
     * @Route("/", name="feats")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TroulitePathfinderBundle:Feat')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Feat entity.
     *
     * @Route("/{id}", name="feats_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Feat $entity)
    {
        return array(
            'entity'      => $entity,
        );
    }
}

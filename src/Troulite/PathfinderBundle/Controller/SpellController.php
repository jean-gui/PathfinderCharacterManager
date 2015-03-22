<?php

namespace Troulite\PathfinderBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Troulite\PathfinderBundle\Entity\Spell;

/**
 * Spell controller.
 *
 * @Route("/spells")
 */
class SpellController extends Controller
{

    /**
     * Lists all Spell entities.
     *
     * @Route("/", name="spells")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TroulitePathfinderBundle:Spell')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Spell entity.
     *
     * @Route("/{id}", name="spells_show")
     * @Method("GET")
     * @Template()
     *
     * @param Spell $spell
     *
     * @return array
     */
    public function showAction(Spell $spell)
    {
        return array(
            'entity'      => $spell,
        );
    }
}

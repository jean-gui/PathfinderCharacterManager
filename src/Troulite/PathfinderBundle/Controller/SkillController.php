<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 30/06/14
 * Time: 20:57
 */

namespace Troulite\PathfinderBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class SkillController
 * @package Troulite\PathfinderBundle\Controller
 *
 * @Route("/skills")
 */
class SkillController extends Controller
{
    /**
     * Lists all Skill entities.
     *
     * @Route("/", name="skills")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $skills = $em->getRepository('TroulitePathfinderBundle:Skill')->findAll();
        $classes = $em->getRepository('TroulitePathfinderBundle:ClassDefinition')->findAll();

        return array(
            'skills' => $skills,
            'classes' => $classes
        );
    }
} 
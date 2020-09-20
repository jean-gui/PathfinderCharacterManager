<?php

namespace App\Controller;

use App\Entity\Rules\ClassDefinition;
use App\Entity\Rules\Skill;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SkillController
 * @package App\Controller
 *
 * @Route("/skills")
 */
class SkillController extends AbstractController
{
    /**
     * Lists all Skill entities.
     *
     * @Route("/", name="skills")
     *
     * @return Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $skills = $em->getRepository(Skill::class)->findAll();
        $classes = $em->getRepository(ClassDefinition::class)->findAll();

        return $this->render('skill/index.html.twig', ['skills' => $skills, 'classes' => $classes]);
    }
} 
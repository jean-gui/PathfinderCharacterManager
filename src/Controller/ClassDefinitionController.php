<?php

namespace App\Controller;

use App\Entity\Rules\ClassDefinition;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * ClassDefinition controller.
 *
 * @Route("/classes")
 */
class ClassDefinitionController extends AbstractController
{
    /**
     * Lists all ClassDefinition entities.
     *
     * @Route("/", name="classes")
     *
     * @return Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(ClassDefinition::class)->findAll();

        return $this->render('class_definition/index.html.twig', ['entities' => $entities]);
    }

    /**
     * Finds and displays a ClassDefinition entity.
     *
     * @Route("/{id}", name="classes_show")
     * @Template()
     *
     * @param ClassDefinition $classDefinition
     *
     * @return Response
     */
    public function showAction(ClassDefinition $classDefinition)
    {
        return $this->render('class_definition/show.html.twig', ['entity' => $classDefinition]);
    }
}

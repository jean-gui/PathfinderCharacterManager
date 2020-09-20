<?php

namespace App\Controller;

use App\Entity\Rules\SubClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * SubClass controller.
 *
 * @Route("/subclasses")
 */
class SubClassController extends AbstractController
{
    /**
     * Finds and displays a SubClass entity.
     *
     * @Route("/{id}", name="subclasses_show")
     *
     * @param SubClass $entity
     *
     * @return Response
     */
    public function showAction(SubClass $entity)
    {
        return $this->render('sub_class/show.html.twig', ['entity' => $entity]);
    }
}

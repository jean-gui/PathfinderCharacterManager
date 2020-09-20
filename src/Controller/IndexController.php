<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('app_login'));
        }

        return $this->render('index/index.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/character-advancement", name="character_advancement")
     *
     * @return Response
     */
    public function characterAdvancementAction()
    {
        return $this->render(
            'default/character_advancement.html.twig',
            ['advancement' => $this->getParameter('character_advancement')]
        );
    }
}

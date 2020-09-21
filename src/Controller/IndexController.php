<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\WebLink\Link;

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

    /**
     * @Route("/hub-url", name="hub-url")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getHubUrl(Request $request)
    {
        // This parameter is automatically created by the MercureBundle
        $hubUrl = $this->getParameter('mercure.default_hub');

        // Link: <http://localhost:3000/.well-known/mercure>; rel="mercure"
        $this->addLink($request, new Link('mercure', $hubUrl));

        return new Response('');
    }
}

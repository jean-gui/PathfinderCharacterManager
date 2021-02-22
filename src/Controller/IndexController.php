<?php

namespace App\Controller;

use App\Entity\Characters\Character;
use App\Entity\User;
use DiceCalc\Calc as DiceRoll;
use DiceCalc\Random;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Notifier\Bridge\Discord\DiscordOptions;
use Symfony\Component\Notifier\Bridge\Discord\Embeds\DiscordEmbed;
use Symfony\Component\Notifier\Bridge\Discord\Embeds\DiscordFieldEmbedObject;
use Symfony\Component\Notifier\Bridge\Discord\Embeds\DiscordFooterEmbedObject;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\WebLink\Link;
use Symfony\Contracts\Translation\TranslatorInterface;
use function is_string;

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

    /**
     * @Route("/roll", name="roll")
     * @IsGranted("ROLE_USER")
     *
     * @param Request             $request
     * @param RouterInterface     $router
     * @param ChatterInterface    $chatter
     * @param TranslatorInterface $translator
     *
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function roll(Request $request, RouterInterface $router, ChatterInterface $chatter, TranslatorInterface $translator)
    : Response
    {
        $referer = $request->headers->get('referer');
        if (!is_string($referer) || !$referer) {
            echo 'Referer is invalid or empty.';

            throw new BadRequestHttpException();
        }

        if (!$request->query->has('e')) {
            throw new BadRequestHttpException();
        }

        $refererPathInfo = Request::create($referer)->getPathInfo();
        $routeInfos = $router->match($refererPathInfo);
        $refererRoute = $routeInfos['_route'] ?? '';

        if ($refererRoute !== 'characters_show') {
            echo sprintf('No route found for the "%s" referer.', $referer);

            throw new BadRequestHttpException();
        }

        $characterId = $routeInfos['id'];
        $expression = $request->query->get('e');
        $character = $this->getDoctrine()->getRepository(Character::class)->find($characterId);

        $message = new ChatMessage('');
        $message->transport('discord');
        $discordOptions = (new DiscordOptions())->username('Pathfinder Character Manager');
        $embed = new DiscordEmbed();
        $embed
            ->color(2021216)
            ->title(
              $translator->trans(
                  'rolled',
                  [
                      '%character%' => $character->getName(),
                      '%dice%'      => $expression,
                  ]
              )
        );
        Random::$queue = "random_int";

        $rolls = explode(';', $expression);

        foreach ($rolls as $roll) {
            $calc          = new DiceRoll($roll);
            $results[]     = ['result' => $calc(), 'details' => $calc->infix()];
            $rawRollResult = preg_replace(['/.*:(.+)].*/', '/ \+ /'], ['$1', ', '], $calc->infix());

            $embed
                ->addField(
                    (new DiscordFieldEmbedObject())
                        ->name($translator->trans('roll'))
                        ->value($roll)
                        ->inline(true)
                )
                ->addField(
                    (new DiscordFieldEmbedObject())
                        ->name($translator->trans('roll.raw'))
                        ->value($rawRollResult)
                        ->inline(true)
                )
                ->addField(
                    (new DiscordFieldEmbedObject())
                        ->name($translator->trans('roll.result'))
                        ->value('**' . $calc() . '**')
                        ->inline(true)
                )
            ;
        }

        $discordOptions->addEmbed($embed);
        $message->options($discordOptions);

        $chatter->send($message);

        return new JsonResponse($results);
    }
}

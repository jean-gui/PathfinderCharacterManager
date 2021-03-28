<?php

namespace App\Controller;

use App\Entity\Characters\Character;
use DiceCalc\Calc as DiceRoll;
use DiceCalc\Random;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Bridge\Discord\DiscordOptions;
use Symfony\Component\Notifier\Bridge\Discord\DiscordTransportFactory;
use Symfony\Component\Notifier\Bridge\Discord\Embeds\DiscordEmbed;
use Symfony\Component\Notifier\Bridge\Discord\Embeds\DiscordFieldEmbedObject;
use Symfony\Component\Notifier\Chatter;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Transport\Dsn;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class DiceRollController extends AbstractController
{
    /**
     * @Route("/characters/{id}/roll", name="roll")
     * @IsGranted("ROLE_USER")
     *
     * @param Character                $character
     * @param Request                  $request
     * @param TranslatorInterface      $translator
     * @param EventDispatcherInterface $eventDispatcher
     * @param HttpClientInterface      $client
     *
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function roll(
        Character $character,
        Request $request,
        TranslatorInterface $translator,
        EventDispatcherInterface $eventDispatcher,
        HttpClientInterface $client
    ) {
        $results = [];
        $form    = $this
            ->createFormBuilder([], ['csrf_protection' => false])
            ->add('expression', null, ['label' => 'roll.expression'])
            ->add('type', TextType::class, ['label' => 'roll.type', 'required' => false])
            ->add('roll', SubmitType::class, ['label' => 'roll.submit'])
            ->setMethod('POST')
            ->setAction($this->generateUrl('roll', ['id' => $character->getId()]))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            ['expression' => $expression, 'type' => $type] = $form->getData();
            $results = $this->rollDice($translator, $expression, $type, $character, $eventDispatcher, $client);

            if ($request->getAcceptableContentTypes()[0] === 'application/json') {
                return new JsonResponse($results);
            } else {
                return $this->render('dice_roll/_result.html.twig', ['results' => $results]);
            }
        }

        return $this->render('dice_roll/custom_roll.html.twig', ['form' => $form->createView(), 'results' => $results]);
    }

    /**
     * @param TranslatorInterface      $translator
     * @param string                   $expression
     * @param string|null              $type
     * @param Character                $character
     * @param EventDispatcherInterface $eventDispatcher
     * @param HttpClientInterface      $client
     *
     * @return array
     * @throws TransportExceptionInterface
     */
    protected function rollDice(
        TranslatorInterface $translator,
        string $expression,
        ?string $type,
        Character $character,
        EventDispatcherInterface $eventDispatcher,
        HttpClientInterface $client
    ): array {
        $discordDsn = $character->getParty()->getDiscordDsn();
        $chatter = null;
        $transport = null;

        if ($discordDsn) {
            $message = new ChatMessage('');
            $message->transport('discord');
            $discordOptions = (new DiscordOptions())->username('Pathfinder Character Manager');
            $embed          = new DiscordEmbed();
            $embed->color(hexdec(substr($character->getColor(), 1)));

            if ($type) {
                $embed->title(
                    $translator->trans(
                        'roll.rolling',
                        [
                            '%character%' => $character->getName(),
                            '%dice%'      => $expression,
                            '%type%'      => $type,
                        ]
                    )
                );
            } else {
                $embed->title(
                    $translator->trans(
                        'roll.rolling.custom',
                        [
                            '%character%' => $character->getName(),
                            '%dice%'      => $expression,
                        ]
                    )
                );
            }
        }

        Random::$queue = "random_int";

        $rolls   = explode(';', $expression);
        $results = [];

        foreach ($rolls as $roll) {
            $calc          = new DiceRoll($roll);
            $rawRollResult = preg_replace(['/.*:(.+)].*/', '/ \+ /'], ['$1', ', '], $calc->infix());
            $results[]     = ['roll' => $roll, 'result' => $calc(), 'details' => $rawRollResult];

            if ($discordDsn) {
                $embed
                    ->addField(
                        (new DiscordFieldEmbedObject())
                            ->name($translator->trans('roll', []))
                            ->value($roll)
                            ->inline(true)
                    )
                    ->addField(
                        (new DiscordFieldEmbedObject())
                            ->name($translator->trans('roll.raw', []))
                            ->value(preg_replace(['/<s>/', '/<\/s>/'], '~~', $rawRollResult))
                            ->inline(true)
                    )
                    ->addField(
                        (new DiscordFieldEmbedObject())
                            ->name($translator->trans('roll.result', []))
                            ->value('**'.$calc().'**')
                            ->inline(true)
                    );
            }
        }

        if ($discordDsn) {
            try {
                $factory   = new DiscordTransportFactory($eventDispatcher, $client);
                $transport = $factory->create(Dsn::fromString($discordDsn));
                $chatter   = new Chatter($transport);

                $discordOptions->addEmbed($embed);
                $message->options($discordOptions);

                $chatter->send($message);
            } catch (Exception $e) {
                $this->addFlash('warning', $e->getMessage());
            }
        }

        return $results;
    }
}

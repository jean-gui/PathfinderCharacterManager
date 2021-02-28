<?php

namespace App\Controller;

use App\Entity\Characters\Character;
use DiceCalc\Calc as DiceRoll;
use DiceCalc\Random;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Bridge\Discord\DiscordOptions;
use Symfony\Component\Notifier\Bridge\Discord\Embeds\DiscordEmbed;
use Symfony\Component\Notifier\Bridge\Discord\Embeds\DiscordFieldEmbedObject;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class DiceRollController extends AbstractController
{
    /**
     * @Route("/characters/{id}/roll", name="roll")
     * @IsGranted("ROLE_USER")
     *
     * @param Character           $character
     * @param Request             $request
     * @param TranslatorInterface $translator
     * @param ChatterInterface    $chatter
     *
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function roll(
        Character $character,
        Request $request,
        TranslatorInterface $translator,
        ChatterInterface $chatter
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
            $results = $this->rollDice($translator, $expression, $type, $character, $chatter);

            if ($request->getAcceptableContentTypes()[0] === 'application/json') {
                return new JsonResponse($results);
            } else {
                return $this->render('dice_roll/_result.html.twig', ['results' => $results]);
            }
        }

        return $this->render('dice_roll/custom_roll.html.twig', ['form' => $form->createView(), 'results' => $results]);
    }

    /**
     * @param TranslatorInterface $translator
     * @param string              $expression
     * @param string              $type
     * @param Character           $character
     * @param ChatterInterface    $chatter
     *
     * @return array
     * @throws TransportExceptionInterface
     */
    protected function rollDice(
        TranslatorInterface $translator,
        string $expression,
        string $type,
        Character $character,
        ChatterInterface $chatter
    ): array {
        $message = new ChatMessage('');
        $message->transport('discord');
        $discordOptions = (new DiscordOptions())->username('Pathfinder Character Manager');
        $embed          = new DiscordEmbed();
        $embed
            ->color(2021216)
            ->title(
                $translator->trans(
                    'roll.rolling',
                    [
                        '%character%' => $character->getName(),
                        '%dice%'      => $expression,
                        '%type%'      => $type
                    ],
                    null
                )
            );
        Random::$queue = "random_int";

        $rolls   = explode(';', $expression);
        $results = [];

        foreach ($rolls as $roll) {
            $calc          = new DiceRoll($roll);
            $rawRollResult = preg_replace(['/.*:(.+)].*/', '/ \+ /'], ['$1', ', '], $calc->infix());
            $results[]     = ['roll' => $roll, 'result' => $calc(), 'details' => $rawRollResult];

            $embed
                ->addField(
                    (new DiscordFieldEmbedObject())
                        ->name($translator->trans('roll', [], null))
                        ->value($roll)
                        ->inline(true)
                )
                ->addField(
                    (new DiscordFieldEmbedObject())
                        ->name($translator->trans('roll.raw', [], null))
                        ->value(preg_replace(['/<s>/', '/<\/s>/'], '~~', $rawRollResult))
                        ->inline(true)
                )
                ->addField(
                    (new DiscordFieldEmbedObject())
                        ->name($translator->trans('roll.result', [], null))
                        ->value('**'.$calc().'**')
                        ->inline(true)
                );
        }

        $discordOptions->addEmbed($embed);
        $message->options($discordOptions);

        $chatter->send($message);

        return $results;
    }
}
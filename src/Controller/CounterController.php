<?php

namespace App\Controller;

use App\Entity\Characters\Character;
use App\Entity\Characters\Counter;
use App\Form\CountersIncreaseType;
use App\Form\CounterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Counter controller.
 *
 * @Route("/characters")
 */
class CounterController extends AbstractController
{
    /**
     * @Route("/{character}/counters", name="counter_show")
     * @Security("request.isMethodSafe() or is_granted('CHARACTER_EDIT', character) or is_granted('ROLE_ADMIN')")
     *
     * @param Character $character
     * @param Request   $request
     *
     * @return RedirectResponse|Response
     */
    public function show(Character $character, Request $request)
    {
        $form = $this->createForm(
            CountersIncreaseType::class,
            $character,
            array(
                'method' => 'PUT',
                'action' => $this->generateUrl('counter_show', array('character' => $character->getId())),
            )
        );

        if ($request->isMethod('PUT')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                if ($form->has('increase_all') && $form->get('increase_all')->isClicked()) {
                    foreach ($character->getCounters() as $counter) {
                        $counter->increase();
                    }

                    $em->flush();

                    return $this->redirectToRoute('characters_show', array('id' => $character->getId()));
                }

                foreach ($form->get('counters') as $child) {
                    if ($child->get('increase')->isClicked()) {
                        /** @var Counter $counter */
                        $counter = $child->getData();

                        if ($counter->getCurrent() < $counter->getMax()) {
                            $counter->increase();

                            $em->flush();
                        } else {
                            $this->addFlash('error', 'counter.error.max_reached');
                        }

                        return $this->redirectToRoute('characters_show', array('id' => $character->getId()));
                    }

                    if ($child->get('decrease')->isClicked()) {
                        /** @var Counter $counter */
                        $counter = $child->getData();

                        if ($counter->getCurrent() > 0) {
                            $counter->decrease();

                            $em->flush();
                        } else {
                            $this->addFlash('error', 'counter.error.min_reached');
                        }

                        return $this->redirectToRoute('characters_show', ['id' => $character->getId()]);
                    }

                    if ($child->get('delete')->isClicked()) {
                        $em->remove($child->getData());
                        $em->flush();

                        return $this->redirectToRoute('characters_show', array('id' => $character->getId()));
                    }
                }
            }
        }

        return $this->render(
            'counter/show.html.twig',
            ['entity' => $character, 'form' => $form->createView()]
        );
    }

    /**
     * @Route("/{character}/counters/new", name="counter_new")
     * @Security("is_granted('CHARACTER_EDIT', character) or is_granted('ROLE_ADMIN')")
     *
     * @param Character $character
     * @param Request   $request
     *
     * @return RedirectResponse|Response
     */
    public function new(Character $character, Request $request)
    {
        $counter = new Counter();
        $counter->setCharacter($character);
        $form = $this->createForm(
            CounterType::class,
            $counter,
            array(
                'action' => $this->generateUrl('counter_new', array('character' => $character->getId())),
                'method' => 'POST'
            )
        );
        $form->add('submit', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($counter);
            $em->flush();

            return $this->redirectToRoute('characters_show', array('id' => $character->getId()));
        }

        return $this->render(
            'counter/new.html.twig',
            ['entity' => $character, 'form' => $form->createView()]
        );
    }
}

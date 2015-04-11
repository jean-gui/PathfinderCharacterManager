<?php

namespace Troulite\PathfinderBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Troulite\PathfinderBundle\Entity\Character;
use Troulite\PathfinderBundle\Entity\Counter;
use Troulite\PathfinderBundle\Form\CounterIncreaseType;
use Troulite\PathfinderBundle\Form\CountersIncreaseType;
use Troulite\PathfinderBundle\Form\CounterType;

/**
 * Counter controller.
 *
 * @Route("/characters")
 */
class CounterController extends Controller
{
    /**
     * @Route("/{character}/counters", name="counter_show")
     * @Method({"GET", "PUT"})
     * @Template()
     *
     * @param Character $character
     * @param Request $request
     *
     * @return array
     */
    public function showAction(Character $character, Request $request)
    {
        $form = $this->createForm(
            new CountersIncreaseType(),
            $character,
            array(
                'method' => 'PUT',
                'action' => $this->generateUrl('counter_show', array('character' => $character->getId())),
            )
        );

        if ($request->isMethod('PUT')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                if ($form->get('increase_all')->isClicked()) {
                    foreach($character->getCounters() as $counter) {
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
                    if ($child->get('delete')->isClicked()) {
                        $em->remove($child->getData());
                        $em->flush();

                        return $this->redirectToRoute('characters_show', array('id' => $character->getId()));
                    }
                }
            }
        }

        return array('entity' => $character, 'form' => $form->createView());
    }

    /**
     * @Route("/{character}/counters/new", name="counter_new")
     * @Method({"GET", "POST"})
     * @Template()
     *
     * @param Character $character
     * @param Request $request
     *
     * @return array
     */
    public function newAction(Character $character, Request $request)
    {
        $counter = new Counter();
        $counter->setCharacter($character);
        $form = $this->createForm(
            new CounterType(),
            $counter,
            array(
                'action' => $this->generateUrl('counter_new', array('character' => $character->getId())),
                'method' => 'POST'
            )
        );
        $form->add('submit', 'submit');

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($counter);
            $em->flush();

            return $this->redirectToRoute('characters_show', array('id' => $character->getId()));
        }

        return (array('entity' => $character, 'form' => $form->createView()));
    }
}

<?php

/*
 * Copyright 2015 Jean-Guilhem Rouel
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Troulite\PathfinderBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Troulite\PathfinderBundle\Entity\Character;
use Troulite\PathfinderBundle\Entity\Counter;
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
     * @Security("request.isMethodSafe() or is_granted('CHARACTER_EDIT', character) or has_role('ROLE_ADMIN')")
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

                if ($form->has('increase_all') && $form->get('increase_all')->isClicked()) {
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
     * @Security("is_granted('CHARACTER_EDIT', character) or has_role('ROLE_ADMIN')")
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

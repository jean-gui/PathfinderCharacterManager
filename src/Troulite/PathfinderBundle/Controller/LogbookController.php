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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Troulite\PathfinderBundle\Entity\Party;
use Troulite\PathfinderBundle\Form\PartyLogbookType;

/**
 * Logbook controller.
 *
 * @Route("/parties")
 */
class LogbookController extends Controller
{
    /**
     * Display a party's logbook.
     *
     * @Route("/{id}/logbook", name="logbook")
     * @Method({"GET"})
     * @Template()
     * @param Party $party
     *
     * @return array
     */
    public function showAction(Party $party)
    {
        return array('entity' => $party);
    }

    /**
     * Lists all Feat entities.
     *
     * @Route("/{id}/logbook/edit", name="logbook_edit")
     * @Method({"GET", "PUT"})
     * @Template()
     * @param Party $party
     *
     * @param Request $request
     *
     * @return array
     */
    public function editAction(Party $party, Request $request)
    {
        $form = $this->createForm(
            new PartyLogbookType(),
            $party,
            array(
                'method' => 'PUT',
            )
        );
        $form->add('submit', 'submit', array('label' => 'Save'));

        if ($request->getMethod() == 'PUT') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->flush();

                return $this->redirect(
                    $this->generateUrl(
                        'logbook',
                        array('id' => $party->getId())
                    )
                );
            }
        }

        //$em = $this->getDoctrine()->getManager();

        //$logbookEntry1 = (new LogbookEntry())->setTitle('Title 3')->setContent('Content 3');
        //$party->getLogbook()->addEntry($logbookEntry1);

        //$party->setLogbook($logbook);

        //$em->flush();

        return array(
            'entity'  => $party,
            'form'    => $form->createView()
        );

    }
}

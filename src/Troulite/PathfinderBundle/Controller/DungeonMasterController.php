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
use Troulite\PathfinderBundle\Entity\Party;
use Troulite\PathfinderBundle\Form\Conditions\PartyConditionsType;

/**
 * Character controller.
 *
 * @Route("/parties")
 */
class DungeonMasterController extends Controller
{
    /**
     * @param Party $party
     * @param Request $request
     *
     * @return array
     * @Route("/{id}/dm", name="party_dm")
     * @Template()
     * @Method({"GET", "PUT"})
     * @Security("request.isMethodSafe() or is_granted('DM_EDIT', party) or has_role('ROLE_ADMIN')")
     *
     */
    public function dungeonMasterAction(Party $party, Request $request)
    {
        $form = $this->createForm(
            new PartyConditionsType(),
            $party,
            array(
                'action' => $this->generateUrl('party_dm', array('id' => $party->getId())),
                'method' => 'PUT',
            )
        );
        $form->add('submit', 'submit', array('label' => 'Update'));

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'character_conditions.updated');

            return $this->redirectToRoute('party_dm', array('id' => $party->getId()));
        }

        return array('entity' => $party, 'form' => $form->createView());
    }
}
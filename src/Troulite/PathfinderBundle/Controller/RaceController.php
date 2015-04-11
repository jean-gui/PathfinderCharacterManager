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
use Troulite\PathfinderBundle\Entity\Race;

/**
 * Race controller.
 *
 * @Route("/races")
 */
class RaceController extends Controller
{

    /**
     * Lists all Race entities.
     *
     * @Route("/", name="races")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TroulitePathfinderBundle:Race')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Race entity.
     *
     * @Route("/{id}", name="races_show")
     * @Method("GET")
     * @Template()
     *
     * @param Race $race
     *
     * @return array
     */
    public function showAction(Race $race)
    {
        return array(
            'entity' => $race,
        );
    }
}

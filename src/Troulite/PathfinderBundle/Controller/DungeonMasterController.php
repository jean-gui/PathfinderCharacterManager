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
use Troulite\PathfinderBundle\Entity\Party;

/**
 * Character controller.
 *
 * @Route("/parties")
 */
class DungeonMasterController extends Controller
{
    /**
     * @param Party $party
     *
     * @Route("/{id}/dm", name="party_dm")
     * @Template()
     * @Method("GET")
     * @Security("request.isMethodSafe() or is_granted('PARTY_EDIT', party.getDungeonMaster()) or has_role('ROLE_ADMIN')")
     *
     * @return array
     */
    public function dungeonMasterAction(Party $party)
    {
        return array('entity' => $party);
    }
}
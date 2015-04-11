<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 30/06/14
 * Time: 20:57
 */
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


/**
 * Class SkillController
 * @package Troulite\PathfinderBundle\Controller
 *
 * @Route("/skills")
 */
class SkillController extends Controller
{
    /**
     * Lists all Skill entities.
     *
     * @Route("/", name="skills")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $skills = $em->getRepository('TroulitePathfinderBundle:Skill')->findAll();
        $classes = $em->getRepository('TroulitePathfinderBundle:ClassDefinition')->findAll();

        return array(
            'skills' => $skills,
            'classes' => $classes
        );
    }
} 
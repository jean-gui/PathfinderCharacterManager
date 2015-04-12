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
use Troulite\PathfinderBundle\Entity\ClassDefinition;
use Troulite\PathfinderBundle\Form\Classes\ClassDefinitionType;

/**
 * ClassDefinition controller.
 *
 * @Route("/classes")
 */
class ClassDefinitionController extends Controller
{

    /**
     * Lists all ClassDefinition entities.
     *
     * @Route("/", name="classes")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TroulitePathfinderBundle:ClassDefinition')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * @Route("/new", name="classes_new")
     * @Method({"GET", "POST"})
     * @Template()
     *
     * @param Request $request
     *
     * @return array
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $classDefinition = new ClassDefinition();
        $array20 = array();
        for ($i = 0; $i < 20; $i++) {
            $array20[] = null;
        }
        $array10 = array();
        for ($i = 0; $i < 10; $i++) {
            $array10[$i] = $array20;
        }
        $array9 = array();
        for ($i = 1; $i < 10; $i++) {
            $array9[$i] = $array20;
        }
        $classDefinition->setBab($array20);
        $classDefinition->setReflexes($array20);
        $classDefinition->setWill($array20);
        $classDefinition->setFortitude($array20);
        $classDefinition->setSpellsPerDay($array9);
        $classDefinition->setKnownSpellsPerLevel($array10);

        $form = $this->createForm(
            new ClassDefinitionType(),
            $classDefinition,
            array('method' => 'POST')
        );
        $form->add('submit', 'submit');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $this->removeEmptyArrays($classDefinition->getSpellsPerDay());
                $this->removeEmptyArrays($classDefinition->getKnownSpellsPerLevel());

                $em->persist($classDefinition);

                $em->flush();

                $this->addFlash('success', 'class_definition.created');

                return $this->redirectToRoute('classes_show', array('id' => $classDefinition->getId()));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/{id}/edit", name="classes_edit")
     * @Method({"GET", "PUT"})
     * @Template()
     *
     * @param ClassDefinition $classDefinition
     * @param Request $request
     *
     * @return array
     */
    public function editAction(ClassDefinition $classDefinition, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $array20 = array();
        for ($i = 0; $i < 20; $i++) {
            $array20[] = null;
        }

        $knownSpellsPerLevel = $classDefinition->getKnownSpellsPerLevel();
        for ($i = count($knownSpellsPerLevel); $i < 10; $i++) {
            $knownSpellsPerLevel[$i] = $array20;
        }
        $classDefinition->setKnownSpellsPerLevel($knownSpellsPerLevel);

        $spellsPerDay = $classDefinition->getSpellsPerDay();
        for ($i = count($spellsPerDay) + 1; $i < 10; $i++) {
            $spellsPerDay[$i] = $array20;
        }
        $classDefinition->setSpellsPerDay($spellsPerDay);

        $form = $this->createForm(
            new ClassDefinitionType(),
            $classDefinition,
            array('method' => 'PUT')
        );
        $form->add('submit', 'submit');

        if ($request->getMethod() == 'PUT') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $this->removeEmptyArrays($classDefinition->getSpellsPerDay());
                $this->removeEmptyArrays($classDefinition->getKnownSpellsPerLevel());

                $em->persist($classDefinition);

                $em->flush();

                $this->addFlash('success', 'class_definition.updated');

                return $this->redirectToRoute('classes_show', array('id' => $classDefinition->getId()));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @param $array
     *
     * @return array
     */
    private function removeEmptyArrays($array)
    {
        $res = array();
        foreach ($array as $key => $subarray) {
            if (array_values($subarray)[0] != null) {
                $res[$key] = $subarray;
            }
        }
        return $res;
    }

    /**
     * Finds and displays a ClassDefinition entity.
     *
     * @Route("/{id}", name="classes_show")
     * @Method("GET")
     * @Template()
     *
     * @param ClassDefinition $classDefinition
     *
     * @return array
     */
    public function showAction(ClassDefinition $classDefinition)
    {
        return array(
            'entity' => $classDefinition,
        );
    }
}

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

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Troulite\PathfinderBundle\Entity\ClassDefinition;
use Troulite\PathfinderBundle\Entity\ClassSpell;
use Troulite\PathfinderBundle\Form\Classes\ClassDefinitionFlow;

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
     * @return array
     */
    public function newAction()
    {
        $classDefinition = new ClassDefinition();
        $array20 = array();
        for ($i = 0; $i < 20; $i++) {
            $array20[] = null;
        }


        return $this->createClassDefinitionForm($classDefinition);

    }

    /**
     * @Route("/{id}/edit", name="classes_edit")
     * @Method({"GET", "PUT", "POST"})
     * @Template()
     *
     * @param ClassDefinition $classDefinition
     *
     * @return array
     */
    public function editAction(ClassDefinition $classDefinition)
    {
        return $this->createClassDefinitionForm($classDefinition);
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

    /**
     * @param ClassDefinition $classDefinition
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function createClassDefinitionForm(ClassDefinition $classDefinition)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $array20 = array();
        for ($i = 0; $i < 20; $i++) {
            $array20[] = null;
        }

        if (count($classDefinition->getBab()) === 0) {
            $classDefinition->setBab($array20);
        }

        if (count($classDefinition->getReflexes()) === 0) {
            $classDefinition->setReflexes($array20);
        }
        if (count($classDefinition->getWill()) === 0) {
            $classDefinition->setWill($array20);
        }
        if (count($classDefinition->getFortitude()) === 0) {
            $classDefinition->setFortitude($array20);
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

        /** @var $flow ClassDefinitionFlow */
        $flow = $this->get('troulite_pathfinder.form.flow.classdefinition');

        // Hmm, that's ugly! But improves performances
        if ($flow->getStorage()->get('flow_classDefinition_data')[1]['castingAbility']) {
            $spells    = $em->getRepository('TroulitePathfinderBundle:Spell')->findAll();
            $newSpells = array();
            foreach ($spells as $spell) {
                /** @noinspection PhpUnusedParameterInspection */
                if (!$classDefinition->getSpells()->exists(function ($key, ClassSpell $cs) use ($spell) {
                    return $spell === $cs->getSpell();
                })
                ) {
                    $classSpell = new ClassSpell();
                    $classSpell->setSpell($spell);
                    $newSpells[] = $classSpell;
                }
            }

            foreach ($newSpells as $classSpell) {
                $classDefinition->addSpell($classSpell);
            }
        }

        $flow->bind($classDefinition);

        $form = $flow->createForm();

        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                // form for the next step
                $form = $flow->createForm();
            } else {
                // flow finished
                $this->removeEmptyArrays($classDefinition->getSpellsPerDay());
                $this->removeEmptyArrays($classDefinition->getKnownSpellsPerLevel());

                foreach ($classDefinition->getSpells() as $classSpell) {
                    if ($classSpell->getSpellLevel() === null) {
                        $classDefinition->removeSpell($classSpell);
                    }
                }

                if (!$classDefinition->getId()) {
                    $em->persist($classDefinition);
                }

                $em->flush();

                $flow->reset(); // remove step data from the session

                $this->addFlash('success', 'class_definition.updated');

                return $this->redirectToRoute('classes_show', array('id' => $classDefinition->getId()));
            }
        }

        return array(
            'form' => $form->createView(),
            'flow' => $flow,
        );
    }
}

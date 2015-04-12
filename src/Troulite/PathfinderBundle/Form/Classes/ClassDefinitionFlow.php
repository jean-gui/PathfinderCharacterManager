<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 19/07/14
 * Time: 19:45
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

namespace Troulite\PathfinderBundle\Form\Classes;


use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;
use Doctrine\ORM\EntityManager;
use Troulite\PathfinderBundle\Entity\ClassDefinition;

/**
 * Class ClassDefinitionFlow
 *
 * @package Troulite\PathfinderBundle\Form\Classes
 */
class ClassDefinitionFlow extends FormFlow
{

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'classDefinition';
    }

    /**
     * {@inheritdoc}
     */
    protected function loadStepsConfig()
    {
        return array(
            array(
                'label' => 'classdefinition.base',
                'type'  => new BaseType(),
            ),
            array(
                'label' => 'class_definition.stats',
                'type'  => new StatsType(),
            ),
            array(
                'label' => 'class_definition.magic',
                'type'  => new MagicType(),
                'skip'  => function ($estimatedCurrentStepNumber, FormFlowInterface $flow) {
                    /** @var ClassDefinition $classDefinition */
                    $classDefinition = $flow->getFormData();
                    return $estimatedCurrentStepNumber > 1 && !$classDefinition->getCastingAbility();
                },
            ),
            array(
                'label' => 'class_definition.spells',
                'type'  => new SpellsType(),
                'skip' => function ($estimatedCurrentStepNumber, FormFlowInterface $flow) {
                    /** @var ClassDefinition $classDefinition */
                    $classDefinition = $flow->getFormData();
                    return $estimatedCurrentStepNumber > 1 && !$classDefinition->getCastingAbility();
                },
            ),
            array(
                'label' => 'class_definition.powers',
                'type'  => new PowersType(),
            ),
        );
    }
} 
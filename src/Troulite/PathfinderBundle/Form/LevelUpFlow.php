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

namespace Troulite\PathfinderBundle\Form;


use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;
use Doctrine\ORM\EntityManager;
use Troulite\PathfinderBundle\Entity\Level;

/**
 * Class LevelUpFlow
 *
 * @package Troulite\PathfinderBundle\Form
 */
class LevelUpFlow extends FormFlow
{
    /**
     * @var array
     */
    private $advancement;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param array $advancement
     * @param EntityManager $em
     */
    public function __construct($advancement, EntityManager $em)
    {
        $this->advancement = $advancement;
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'levelUp';
    }

    /**
     * {@inheritdoc}
     */
    protected function loadStepsConfig()
    {
        return array(
            array(
                'label' => 'Base',
                'type'  => new LevelUpClassType($this->advancement),
            ),
            array(
                'label' => 'Subclass',
                'type'  => new LevelUpSubClassType($this->em),
                'skip'  => function ($estimatedCurrentStepNumber, FormFlowInterface $flow) {
                    /** @var Level $level */
                    $level = $this->getFormData();
                    return !$level->getClassDefinition() || !$level->getClassDefinition()->getSubClasses()
                        || $level->getClassDefinition()->getSubClasses()->count() === 0
                        || $level->getValue() !== 1;
                }
            ),
            array(
                'label' => 'Class Summary',
                'type'  => new LevelUpClassSummaryHpType(),
            ),
            array(
                'label' => 'Feats',
                'type'  => new LevelUpFeatsType($this->advancement, $this->em),
            ),
            array(
                'label' => 'Spells',
                'type'  => new LevelUpSpellsType($this->em),
            ),
            array(
                'label' => 'Skills',
                'type'  => new LevelUpSkillsType($this->em),
            ),
            array(
                'label' => 'Confirmation',
            ),
        );
    }
} 
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

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Entity\CharacterClassPower;
use Troulite\PathfinderBundle\Entity\Level;
use Troulite\PathfinderBundle\Form\Type\ClassPowerChoiceType;

/**
 * Class LevelUpClassType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class LevelUpClassSummaryHpType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                /** @var $level Level */
                $level     = $event->getData();
                $character = $level->getCharacter();
                $classDefinition = $level->getClassDefinition();
                $classLevel = $character->getLevel($classDefinition);
                $classLevelPowers = $classDefinition->getPowers($classLevel);
                $form      = $event->getForm();

                // First level hpRoll should always be maxed out, so do not add the field in this case
                if ($character->getLevel() > 1) {
                    $form->add('hpRoll');
                }

                if ($character->getFavoredClass() === $level->getClassDefinition()) {
                    $form->add(
                        'extraPoint',
                        'choice',
                        array('choices' => array('hp' => 'Hit Point', 'skill' => 'Skill'))
                    );
                }

                // Class Powers requiring a choice
                $choices = null;
                foreach ($classLevelPowers as $power) {
                    $alreadyThere = false;
                    foreach ($level->getClassPowers() as $classPower) {
                        if ($classPower->getClassPower() === $power) {
                            $alreadyThere = true;
                            break;
                        }
                    }
                    if (
                        !$alreadyThere &&
                        (
                            (count($power->getEffects()) > 0 && array_key_exists('choice', $power->getEffects())) ||
                            ($power->getChildren()->count() > 0)
                        )
                    ) {
                        $level->addClassPower((new CharacterClassPower())->setClassPower($power));
                    }
                }

                $form->add(
                    'classPowers',
                    'collection',
                    array(
                        'label' => /** @Ignore */ false,
                        'type' => new ClassPowerChoiceType(),
                        'options' => array('label' => /** @Ignore */ false)
                    )
                );
            }
        );
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troulite\PathfinderBundle\Entity\Level'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troulite_pathfinderbundle_level';
    }
}

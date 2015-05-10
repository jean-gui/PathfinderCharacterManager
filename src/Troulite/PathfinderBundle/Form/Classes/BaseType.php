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

namespace Troulite\PathfinderBundle\Form\Classes;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Entity\Abilities;

/**
 * Class BaseType
 *
 * @package Troulite\PathfinderBundle\Form\Classes
 */
class BaseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',
                null,
                array(
                    'horizontal_label_class'         => 'col-sm-2',
                    'horizontal_input_wrapper_class' => 'col-sm-10',
                )
            )
            ->add('longDescription',
                null,
                array(
                    'horizontal_label_class'         => 'col-sm-2',
                    'horizontal_input_wrapper_class' => 'col-sm-10',
                    'attr' => array('class' => 'wysiwyg')
                )
            )
            ->add('hpDice',
                null,
                array(
                    'horizontal_label_class'         => 'col-sm-2',
                    'horizontal_input_wrapper_class' => 'col-sm-10',
                )
            )
            ->add('skillPoints',
                null,
                array(
                    'horizontal_label_class'         => 'col-sm-2',
                    'horizontal_input_wrapper_class' => 'col-sm-10',
                )
            )
            ->add('classSkills',
                null,
                array(
                    'horizontal_label_class'         => 'col-sm-2',
                    'horizontal_input_wrapper_class' => 'col-sm-10',
                )
            )
            ->add(
                'castingAbility',
                'choice',
                array(
                    'choices'                        => array(
                        /** @Ignore */
                        Abilities::INTELLIGENCE => Abilities::INTELLIGENCE,
                        /** @Ignore */
                        Abilities::WISDOM       => Abilities::WISDOM,
                        /** @Ignore */
                        Abilities::CHARISMA     => Abilities::CHARISMA
                    ),
                    'required'                       => false,
                    'horizontal_label_class'         => 'col-sm-2',
                    'horizontal_input_wrapper_class' => 'col-sm-10',
                )
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Troulite\PathfinderBundle\Entity\ClassDefinition'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troulite_pathfinderbundle_classdefinition';
    }
}

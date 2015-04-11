<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 02/08/14
 * Time: 17:05
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


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CastPreparedSpellType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class CastPreparedSpellType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'targets',
            'choice',
            array(
                'label'       => /** @Ignore */ $options['spell'] . ' (' . $options['class'] . ')',
                'choices'     => $options['targets'],
                'empty_value' => 'Target'
            )
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array('targets', 'spell', 'class'));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'troulite_pathfinder_bundle_cast_prepared_spells';
    }
}
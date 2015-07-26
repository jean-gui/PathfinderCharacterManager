<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 14/07/14
 * Time: 21:25
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

namespace Troulite\PathfinderBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
/**
 * Class AddCharacterFeatType
 *
 * @package Troulite\PathfinderBundle\Form\Type
 */
class AddCharacterFeatType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$featTransformer = new FeatToCharacterFeatTransformer($options['level']);
        //$builder->addModelTransformer($featTransformer);

        $builder->add(
            'feat',
            'entity',
            array(
                'class'   => 'TroulitePathfinderBundle:Feat',
                'choices' => $options['choices'][$builder->getName()],
                'label'   => false
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'addcharacterfeat';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Troulite\PathfinderBundle\Entity\CharacterFeat'
            )
        );
        $resolver->setRequired(array('level', 'choices'));
    }


} 
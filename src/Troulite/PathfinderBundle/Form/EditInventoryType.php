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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Form\Type\EditInventoryItemType;

/**
 * Class EditInventoryType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class EditInventoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'inventory_items',
                'collection',
                array(
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'type'         => new EditInventoryItemType(),
                    'label'        => 'items',
                    'options'      => array('label' => /** @Ignore */ false),
                    'widget_add_btn' => array('icon' => 'plus-sign', 'label' => 'add.item'),
                    'widget_remove_btn' => array('icon' => 'trash', 'label' => 'remove.item'),
                    'show_legend' => false
                )
            )
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troulite\PathfinderBundle\Entity\Character'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troulite_pathfinderbundle_inventory';
    }
}

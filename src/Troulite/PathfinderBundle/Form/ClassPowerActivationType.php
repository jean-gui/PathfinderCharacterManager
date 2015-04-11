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

/**
 * Class ClassPowerActivationType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class ClassPowerActivationType extends AbstractType
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
                /** @var $ccp CharacterClassPower */
                $ccp  = $event->getData();
                $form = $event->getForm();

                if ($ccp->getClassPower()->isCastable() && !$ccp->isActive()) {
                    $choices = array('other' => 'Other', 'allies' => 'Allies');
                    foreach ($ccp->getCharacter()->getParty()->getCharacters() as $ally) {
                        $choices[$ally->getId()] = $ally->getName();
                    }
                    $form->add(
                        'active',
                        'choice',
                        array(
                            'choices'  => $choices,
                            'mapped'   => false,
                            'required' => false,
                        )
                    )
                    ->add(
                        'cancel',
                        'checkbox',
                        array(
                            'mapped' => false,
                            'required' => false,
                            'widget_checkbox_label' => 'widget',
                            'label_attr' => array('class' => null)

                        )
                    );
                } else {
                    $form->add(
                        'active',
                        null,
                        array("required" => false, 'horizontal_label_class' => null)
                    );
                }
            }
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Troulite\PathfinderBundle\Entity\CharacterClassPower'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'classpoweractivation';
    }
}

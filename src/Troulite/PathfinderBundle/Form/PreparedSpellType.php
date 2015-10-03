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
use Symfony\Component\OptionsResolver\OptionsResolver;
use Troulite\PathfinderBundle\Entity\PreparedSpell;

/**
 * Class PreparedSpellType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class PreparedSpellType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($options) {
                $form          = $event->getForm();

                $allChoices = $options['choices'];
                $slotNumber = (int) $form->getName();
                $level      = 0;
                $choices    = array();

                // Compute spell level and pick the right choice list from $allChoices
                foreach ($allChoices as $spellLevel => $slots) {
                    if ($slotNumber < count($slots)) {
                        $level = $spellLevel;
                        $choices = $slots[$slotNumber];
                        break;
                    } else {
                        $slotNumber -= count($slots);
                    }
                }

                $form->add(
                    'spell',
                    null,
                    array(
                        'label' => /** @Ignore */ 'Level ' . $level . ' Slot',
                        'choices' => $choices,
                    )
                );
            }
        );
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troulite\PathfinderBundle\Entity\PreparedSpell'
        ));
        $resolver->setRequired(array('choices'));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troulite_pathfinderbundle_preparedspell';
    }
}

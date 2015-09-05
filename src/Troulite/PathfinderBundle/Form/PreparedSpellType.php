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

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Entity\Character;
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
                /** @var PreparedSpell $preparedSpell */
                $preparedSpell = $event->getData();
                /** @var Character $character */
                $character     = $options['character'];
                $form          = $event->getForm();
                $groupedSpells = array();
                /** @var $em EntityManager */
                $em = $options['em'];

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
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troulite\PathfinderBundle\Entity\PreparedSpell'
        ));
        $resolver->setRequired(array('em', 'preparedLevels', 'character', 'choices'));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troulite_pathfinderbundle_preparedspell';
    }
}

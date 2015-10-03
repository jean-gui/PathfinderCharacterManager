<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 02/08/14
 * Time: 19:35
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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Troulite\PathfinderBundle\Entity\Character;

/**
 * Class UncastSpellsType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class UncastSpellsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                /** @var $character Character */
                $character = $event->getData();
                $form      = $event->getForm();

                $i = 0;
                if ($character->getParty()) {
                    foreach ($character->getParty()->getCharacters() as $ally) {
                        foreach ($ally->getSpellEffects() as $spellEffect) {
                            if ($spellEffect->getCaster() === $character) {
                                $form->add(
                                    $i++,
                                    new UncastSpellType(),
                                    array(
                                        'mapped'      => false,
                                        'label'       => /** @Ignore */ $spellEffect->getSpell() . ' on ' . $spellEffect->getCharacter(
                                            ),
                                        'spellEffect' => $spellEffect
                                    )
                                );
                            }
                        }
                    }
                }

                if ($form->count() > 0) {
                    $form->add('Uncast', 'submit', array('label' => 'uncast'));
                }
            }
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Troulite\PathfinderBundle\Entity\Character'
            )
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'troulite_pathfinder_bundle_uncast_spells';
    }
}
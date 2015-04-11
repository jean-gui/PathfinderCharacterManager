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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Entity\Character;

/**
 * Class CastSpellsType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class CastSpellsType extends AbstractType
{
    /**
     * @var array
     */
    private $extra_spells;

    /**
     * @param array $extra_spells
     */
    public function __construct($extra_spells)
    {
        $this->extra_spells = $extra_spells;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                /** @var $character Character */
                $character = $event->getData();
                $form = $event->getForm();
                $targets = array('other' => 'Other', 'allies' => 'Allies');
                if ($character->getParty()) {
                    foreach ($character->getParty()->getCharacters() as $ally) {
                        $targets[$ally->getId()] = $ally->getName();
                    }
                }

                $form->add(
                    'castable_spells_by_class_by_spell_level',
                    'collection',
                    array(
                        'label'   => /** @Ignore */ false,
                        'type'    => new CastableClassSpellsType(),
                        'options' => array(
                            'caster'  => $character,
                            'targets' => $targets,
                            'attr' => array('class' => 'row')
                        ),
                        'required' => false
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
        $resolver->setDefaults(
            array(
                'data_class' => 'Troulite\PathfinderBundle\Entity\Character'
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'troulite_pathfinder_bundle_cast_spells';
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['extra_spells'] = $this->extra_spells;
        $view->vars['horizontal'] = false;
    }
}
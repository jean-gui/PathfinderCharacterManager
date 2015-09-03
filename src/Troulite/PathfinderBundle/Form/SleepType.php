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

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Entity\Character;
use Troulite\PathfinderBundle\Entity\ClassDefinition;
use Troulite\PathfinderBundle\Entity\PreparedSpell;

/**
 * Class PreparedSpellType
 *
 * @package Troulite\PathfinderBundle\Form
 * @todo there are bugs when a character has fewer spells than before. Some dropdowns don't get the right default value
 */
class SleepType extends AbstractType
{
    /**
     * @var array
     */
    private $extra_spells;

    /**
     * @param array $extra_spells
     */
    public function __construct($extra_spells) {
        $this->extra_spells = $extra_spells;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($options) {
                /** @var $character Character */
                $character = $event->getData();
                $form      = $event->getForm();

                /** @var int[] $preparedLevels */
                $preparedLevels = array();

                foreach ($character->getLevelPerClass() as $classLevel) {
                    /** @var $class ClassDefinition */
                    $class = $classLevel['class'];
                    /** @var $level int */
                    $level = $classLevel['level'];
                    /** @var array $previouslyPreparedSpellsByLevel */
                    $previouslyPreparedSpellsByLevel = $character->getPreparedSpellsByLevel();

                    if ($class->isPreparationNeeded()) {
                        // $levels starts at 0 but means character level 1, hence the -1 below
                        foreach ($class->getSpellsPerDay() as $spellLevel => $levels) {
                            /** @var PreparedSpell[] $previouslyPreparedSpells */
                            if (array_key_exists($spellLevel, $previouslyPreparedSpellsByLevel)) {
                                $previouslyPreparedSpells = $previouslyPreparedSpellsByLevel[$spellLevel];
                            } else {
                                $previouslyPreparedSpells = array();
                            }
                            // A character has $levels[$level - 1] spells + some more if he has a high ability score
                            $totalSpells = $levels[$level - 1];
                            if ($levels[$level - 1] > -1) {
                                $abMod = $character->getModifierByAbility($class->getCastingAbility());
                                $totalSpells += $this->extra_spells[$abMod][$spellLevel];
                            }
                            $previousTotalSpells = count($previouslyPreparedSpells);
                            if ($totalSpells < $previousTotalSpells) {
                                // We have fewer spells than last time we slept, remove some
                                for ($i = $totalSpells; $i < $previousTotalSpells; $i++) {
                                    foreach ($character->getPreparedSpells() as $preparedSpell) {
                                        if ($preparedSpell->getSpellLevel() === $spellLevel) {
                                            $character->removePreparedSpell($preparedSpell);
                                            break;
                                        }
                                    }
                                }
                                // Because ArrayCollections don't get reindexed automatically, do it manually
                                $character->setPreparedSpells(
                                    new ArrayCollection(array_values($character->getPreparedSpells()->toArray()))
                                );
                            }

                            for ($i = 0; $i < $totalSpells; $i++) {
                                if ($i >= $previousTotalSpells) {
                                    // We have more spells than last time we slept, add them
                                    $character->addPreparedSpell(new PreparedSpell($character, null, $class));
                                }

                                $preparedLevels[] = $spellLevel;
                            }
                        }
                    }
                }

                $form->add(
                    'preparedSpells',
                    'collection',
                    array(
                        'label' => 'Prepare Spells',
                        'type' => new PreparedSpellType(),
                        'options' => array(
                            'label'          => /** @Ignore */ false,
                            'em'             => $options['em'],
                            'preparedLevels' => $preparedLevels,
                            'character'      => $character
                        )
                    )
                );
            }
        );

        $builder->add('Sleep', 'submit');
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
        $resolver->setRequired(array('em'));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'troulite_pathfinder_bundle_sleep';
    }
}
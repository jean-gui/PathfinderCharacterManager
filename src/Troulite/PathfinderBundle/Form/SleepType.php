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
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Entity\Character;
use Troulite\PathfinderBundle\Entity\ClassDefinition;
use Troulite\PathfinderBundle\Entity\ClassSpell;
use Troulite\PathfinderBundle\Entity\PreparedSpell;
use Troulite\PathfinderBundle\Entity\SubClass;

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

                $choices = array();

                /** @var array $previouslyPreparedSpellsByLevel */
                $previouslyPreparedSpellsByLevel = $character->getPreparedSpellsByLevel();
                foreach ($character->getPreparedSpells() as $ps) {
                    $character->removePreparedSpell($ps);
                }
                $character->setPreparedSpells(new ArrayCollection());

                $levelPerClass = array();
                foreach ($character->getLevels() as $level) {
                    if ($level->getClassDefinition()->isPrestige()) {
                        $id = $level->getParentClass()->getId();
                    } else {
                        $id = $level->getClassDefinition()->getId();
                    }

                    if (array_key_exists($id, $levelPerClass)) {
                        $levelPerClass[$id]++;
                    } else {
                        $levelPerClass[$id] = 1;
                    }
                }

                foreach ($character->getLevelPerClass() as $classLevel) {
                    /** @var EntityManager $em */
                    $em = $options['em'];
                    /** @var $class ClassDefinition */
                    $class = $classLevel['class'];

                    // Prestige classes rely on parent class for casting spells
                    if ($class->isPrestige()) {
                        continue;
                    }

                    /** @var $level int */
                    $level = $levelPerClass[$class->getId()];

                    if ($class->isPreparationNeeded()) {
                        // Get all sublcasses of this class adding extra slots
                        /** @var SubClass[] $subClasses */
                        $subClasses = array();
                        if ($class->getSubClasses() && $class->getSubClasses()->count() > 0) {
                            foreach ($character->getLevels() as $l) {
                                if (
                                    $l->getClassDefinition() === $class &&
                                    $l->getSubClasses() && $l->getSubClasses()->count() > 0
                                ) {
                                    foreach ($l->getSubClasses() as $sc) {
                                        if ($sc->getExtraSpellSlot()) {
                                            $subClasses[] = $sc;
                                        }
                                    }
                                }
                            }
                        }

                        // $levels starts at 0 but means character level 1, hence the -1 below
                        foreach ($class->getSpellsPerDay() as $spellLevel => $levels) {
                            $spellsForClassForSpellLevel = array();
                            $spellsPerDayForLevel = $levels[$level - 1];
                            // -1 means "cannot cast spells for this level"
                            if ($spellsPerDayForLevel > -1) {
                                // A character has $levels[$level - 1] spells + some more if he has a high ability score
                                $abMod = $character->getModifierByAbility($class->getCastingAbility());
                                $extraSpellsCount = $this->extra_spells[$abMod][$spellLevel];
                                $totalSpells = $spellsPerDayForLevel + $extraSpellsCount + $character->getSpellSlotBonuses()->get($spellLevel);

                                for ($i = 0; $i < $totalSpells; $i++) {
                                    if (array_key_exists($spellLevel, $previouslyPreparedSpellsByLevel)) {
                                        $pps = array_shift($previouslyPreparedSpellsByLevel[$spellLevel]);
                                        if ($pps) {
                                            $pps = $pps->getSpell();
                                        }
                                    } else {
                                        $pps = null;
                                    }
                                    $character->addPreparedSpell(
                                        new PreparedSpell($character, $pps, $class)
                                    );
                                }

                                // this class learns spells at every level (profane magic)
                                $knownSpellsBySpellLevel = $character->getLearnedSpellsBySpellLevel();
                                if ($class->getKnownSpellsPerLevel() && array_key_exists($spellLevel, $knownSpellsBySpellLevel)) {
                                    if (array_key_exists($spellLevel, $knownSpellsBySpellLevel)) {
                                        $r = array_filter(
                                            $knownSpellsBySpellLevel,
                                            function ($l) use ($spellLevel) {
                                                return $l <= $spellLevel;
                                            },
                                            ARRAY_FILTER_USE_KEY
                                        );

                                        $r = array_map(
                                            function ($arr) {
                                                $res = array_map(
                                                    function (ClassSpell $cs)
                                                    {
                                                        return $cs->getSpell();
                                                    },
                                                    $arr
                                                );
                                                return $res;
                                            },
                                            $r
                                        );

                                        // We manually need to add level 0 spells
                                        if (!array_key_exists(0, $knownSpellsBySpellLevel)) {
                                            $qb = $em->createQueryBuilder()->select('cs')
                                                ->from('TroulitePathfinderBundle:ClassSpell', 'cs')
                                                ->join('TroulitePathfinderBundle:Spell', 'sp', Join::WITH,
                                                    'sp = cs.spell')
                                                ->andWhere('cs.class = ?1')
                                                ->andWhere('cs.spellLevel <= 0')
                                                ->addOrderBy('cs.spellLevel', 'ASC')
                                                ->addOrderBy('sp.name', 'ASC');
                                            $qb->setParameter(1, $class);

                                            /** @var ClassSpell[] $spells */
                                            $spells = $qb->getQuery()->execute();
                                            if ($spells) {
                                                foreach ($spells as $cs) {
                                                    $spellsForClassForSpellLevel['Level ' . $cs->getSpellLevel() . ' spells'][] = $cs->getSpell();
                                                }
                                            }
                                        }

                                        foreach ($r as $k => $v) {
                                            $spellsForClassForSpellLevel['Level ' . $k . ' spells'] = $v;
                                        }
                                    }
                                    $spellsForClassForSpellLevel = array_reverse($spellsForClassForSpellLevel);
                                } else { // this class knows all spells (divine magic)
                                    $qb = $em->createQueryBuilder()->select('cs')
                                        ->from('TroulitePathfinderBundle:ClassSpell', 'cs')
                                        ->join('TroulitePathfinderBundle:Spell', 'sp', Join::WITH, 'sp = cs.spell')
                                        ->andWhere('cs.class = ?1')
                                        ->andWhere('cs.spellLevel <= ?2')
                                        ->addOrderBy('cs.spellLevel', 'DESC')
                                        ->addOrderBy('sp.name', 'ASC');
                                    $qb->setParameter(1, $class)
                                        ->setParameter(2, $spellLevel);

                                    /** @var ClassSpell[] $spells */
                                    $spells = $qb->getQuery()->execute();
                                    if ($spells) {
                                        foreach ($spells as $cs) {
                                            $spellsForClassForSpellLevel['Level ' . $cs->getSpellLevel() . ' spells'][] = $cs->getSpell();
                                        }
                                    }
                                }

                                if (count($spellsForClassForSpellLevel) > 0) {
                                    for ($i = 0; $i < $totalSpells; $i++) {
                                        $choices[$spellLevel][] = $spellsForClassForSpellLevel;
                                    }
                                }

                                // Bonus slots and spells provided by subclasses
                                if ($spellLevel > 0 && count($subClasses) > 0) {
                                    /** @var ClassSpell[] $subClassesClassSpells */
                                    $subClassesClassSpells = array();
                                    /** @var ClassSpell[] $subClassSpells */
                                    $subClassSpells      = array();
                                    foreach ($subClasses as $subClass) {
                                        if ($subClass->getSpells() && $subClass->getSpells()->count() > 0) {
                                            $subClassClassSpells = array_filter(
                                                $subClass->getSpells()->toArray(),
                                                function (ClassSpell $cs) use ($spellLevel) {
                                                    return $cs->getSpellLevel() <= $spellLevel;
                                                }
                                            );
                                            $subClassesClassSpells = array_merge(
                                                $subClassesClassSpells,
                                                $subClassClassSpells
                                            );
                                        }
                                    }

                                    $hasSpells = count($subClassesClassSpells) > 0;

                                    if ($hasSpells) {
                                        if ($class->getKnownSpellsPerLevel()) {
                                            $subClassesClassSpells = array_filter(
                                                $subClassesClassSpells,
                                                function (ClassSpell $cs) use ($character) {
                                                    foreach ($character->getLearnedSpells() as $spell) {
                                                        if ($spell->getSpellLevel() === 0 || $spell->getSpell() === $cs->getSpell()) {
                                                            return true;
                                                        }
                                                    }
                                                    return false;
                                                }
                                            );
                                            $hasSpells = count($subClassesClassSpells) > 0;
                                        }
                                        if ($hasSpells) {
                                            foreach ($subClassesClassSpells as $cs) {
                                                $subClassSpells['Level ' . $cs->getSpellLevel() . ' spells'][] = $cs->getSpell();
                                            }
                                            krsort($subClassSpells);
                                            $choices[$spellLevel][] = $subClassSpells;
                                        }
                                    } else {
                                        $choices[$spellLevel][] = $spellsForClassForSpellLevel;
                                    }

                                    if ($hasSpells) {
                                        $spell = null;
                                        // Try to find the most likely spell to place in a subclass spell slot
                                        if (array_key_exists($spellLevel, $previouslyPreparedSpellsByLevel)) {
                                            // Should most likely be the last prepared spell, hence array_reverse
                                            $reverse = array_reverse($previouslyPreparedSpellsByLevel[$spellLevel]);
                                            while ($pps = array_shift($reverse)) {
                                                foreach ($choices[$spellLevel][count($choices[$spellLevel]) - 1] as $s) {
                                                    if (in_array($pps->getSpell(), $s)) {
                                                        $spell = $pps->getSpell();
                                                        break 2;
                                                    }
                                                }
                                            }
                                        }

                                        $character->addPreparedSpell(
                                            new PreparedSpell($character, $spell, $class)
                                        );
                                    }
                                }
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
                            'choices'        => $choices
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
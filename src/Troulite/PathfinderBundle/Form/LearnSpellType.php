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
use Symfony\Component\OptionsResolver\OptionsResolver;
use Troulite\PathfinderBundle\Entity\Character;
use Troulite\PathfinderBundle\Entity\ClassDefinition;
use Troulite\PathfinderBundle\Entity\ClassSpell;

/**
 * Class LevelUpSpellsType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class LearnSpellType extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $this->em;
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($em) {
                /** @var Character $character */
                $character   = $event->getData();
                $knownSpells = $character->getLearnedSpells();

                $canLearnClasses = array();

                foreach ($character->getLevelPerClass() as $classId => $classLevel) {
                    /** @var ClassDefinition $class */
                    $class = $classLevel['class'];
                    if ($class->isAbleToLearnNewSpells()) {
                        $canLearnClasses[] = $class;
                    }
                }

                $learnableSpells = $em->getRepository('TroulitePathfinderBundle:ClassSpell')->findBy(
                    array('class' => $canLearnClasses, 'spellLevel' => array(1,2,3,4,5,6,7,8,9))
                );

                $groupedLearnableSpells = array();
                foreach ($learnableSpells as $classSpell) {
                    if (!in_array($classSpell, $knownSpells, true)) {
                        $group                            = $classSpell->getClass() . ' level ' . $classSpell->getSpellLevel() . ' spells';
                        $groupedLearnableSpells[$group][] = $classSpell;
                    }
                }

                $event->getForm()->add(
                    'spell',
                    'entity',
                    array(
                        'class'   => 'Troulite\PathfinderBundle\Entity\ClassSpell',
                        'mapped'  => false,
                        'choices' => $groupedLearnableSpells
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
            'data_class' => 'Troulite\PathfinderBundle\Entity\Character'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troulite_pathfinderbundle_levelspells';
    }
}

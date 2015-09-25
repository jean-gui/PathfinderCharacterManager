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
use Troulite\PathfinderBundle\Entity\ClassSpell;
use Troulite\PathfinderBundle\Entity\Level;
use Troulite\PathfinderBundle\Form\Type\AddCharacterSpellType;

/**
 * Class LevelUpSpellsType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class LevelUpSpellsType extends AbstractType
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
                /** @var $level Level */
                $level = $event->getData();
                $character = $level->getCharacter();
                $class = $level->getClassDefinition();
                $classLevel = $character->getLevel($class);
                /*
                 * "When a new loremaster level is gained, the character gains new spells per day as if he had also
                 * gained a level in a spellcasting class he belonged to before adding the prestige class. He does not,
                 * however, gain other benefits a character of that class would have gained, except for additional
                 * spells per day, spells known (if he is a spontaneous spellcaster), and an increased effective level
                 * of spellcasting."
                 */
                if ($class->isPrestige() && $level->getParentClass() && !$level->getParentClass()->isPreparationNeeded()) {
                    $class = $level->getParentClass();
                    $classLevel += $character->getLevel($level->getParentClass());
                }
                $form  = $event->getForm();

                if ($class && $class->getKnownSpellsPerLevel()) {
                    $learned = $character->getLearnedSpells();
                    array_walk($learned, function (ClassSpell $s) {
                        return $s->getId();
                    });
                    $spellLevels = array();
                    foreach ($class->getKnownSpellsPerLevel() as $spellLevel => $known) {
                        $spellsToAdd = $known[$classLevel - 1];

                        if ($classLevel > 1) {
                            $spellsToAdd -= $known[$classLevel - 2];
                        }

                        // We don't want to add spells already added to this level again
                        foreach ($level->getLearnedSpells() as $cs) {
                            if ($cs->getSpellLevel() === $spellLevel) {
                                $spellsToAdd--;
                            }
                        }

                        if ($spellsToAdd < 1) {
                            continue;
                        }

                        $spellLevels[] = $spellLevel;

                        while ($spellsToAdd > 0) {
                            $level->addLearnedSpell((new ClassSpell())->setClass($class)->setSpellLevel($spellLevel));
                            $spellsToAdd--;
                        }
                    }

                    $form->add(
                        'learnedSpells',
                        'collection',
                        array(
                            'label'   => /** @Ignore */ 'New Spell' . ($level->getLearnedSpells()->count() > 1 ? 's' : ''),
                            'type'    => new AddCharacterSpellType(),
                            'options' => array(
                                'learned' => $learned,
                                'em'      => $em,
                                'class-definition' => $class,
                                'label' => /** @Ignore */ false
                            )
                        )
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
        $resolver->setDefaults(array(
            'data_class' => 'Troulite\PathfinderBundle\Entity\Level'
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

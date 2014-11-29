<?php

namespace Troulite\PathfinderBundle\Form;

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

                /** @var PreparedSpell[] $preparedSpells */
                $preparedSpells = array();
                /** @var int[] $preparedLevels */
                $preparedLevels = array();

                foreach ($character->getLevelPerClass() as $classLevel) {
                    /** @var $class ClassDefinition */
                    $class = $classLevel['class'];
                    /** @var $level int */
                    $level = $classLevel['level'];
                    /** @var array $previouslyPreparedSpellsByLevel */
                    $previouslyPreparedSpellsByLevel = $character->getPreparedSpellsByLevel();

                    /** @var PreparedSpell[] $preparedSpells */
                    $preparedSpells = array();

                    if ($class->isPreparationNeeded()) {
                        // $levels starts at 0 but means character level 1, hence the -1 below
                        foreach ($class->getSpellsPerDay() as $spellLevel => $levels) {
                            /** @var PreparedSpell[] $previouslyPreparedSpells */
                            if (array_key_exists($spellLevel, $previouslyPreparedSpellsByLevel)) {
                                $previouslyPreparedSpells = $previouslyPreparedSpellsByLevel[$spellLevel];
                            } else {
                                $previouslyPreparedSpells = array();
                            }
                            // A character has $levels[$level - 1] spells + some more if he has a ability score
                            for (
                                $i = 0;
                                $i < $levels[$level - 1] +
                                $this->extra_spells
                                    [$character->getModifierByAbility($class->getCastingAbility())]
                                    [$spellLevel];
                                $i++) {
                                if ($i < count($previouslyPreparedSpells)) {
                                    $preparedSpells[] = $previouslyPreparedSpells[$i];
                                } else {
                                    $preparedSpells[] = new PreparedSpell($character, null, $class);
                                }

                                $preparedLevels[] = $spellLevel;
                            }
                        }
                    }
                }

                $character->getPreparedSpells()->clear();

                foreach ($preparedSpells as $spell) {
                    $character->addPreparedSpell($spell);
                }

                $form->add(
                    'preparedSpells',
                    'collection',
                    array(
                        'label' => 'Prepare Spells',
                        'type' => new PreparedSpellType(),
                        'options' => array(
                            'label' => false,
                            'em'    => $options['em'],
                            'preparedLevels' => $preparedLevels
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
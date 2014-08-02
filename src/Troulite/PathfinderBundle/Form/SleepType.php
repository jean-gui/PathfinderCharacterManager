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

                $prepared = $character->getPreparedSpells();
                $prepared->clear();

                $preparedLevels = array();

                foreach ($character->getLevelPerClass() as $classLevel) {
                    /** @var $class ClassDefinition */
                    $class = $classLevel['class'];
                    /** @var $level int */
                    $level = $classLevel['level'];

                    if ($class->isPreparationNeeded()) {
                        foreach ($class->getSpellsPerDay() as $spellLevel => $levels) {
                            for ($i = 0; $i < $levels[$level - 1]; $i++) {
                                $character->addPreparedSpell(new PreparedSpell($character, null, $class));
                                $preparedLevels[] = $spellLevel;
                            }
                        }
                    }
                }

                $form->add(
                    'preparedSpells',
                    'collection',
                    array(
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
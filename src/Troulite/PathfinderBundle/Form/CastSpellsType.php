<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 02/08/14
 * Time: 17:05
 */

namespace Troulite\PathfinderBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Entity\Character;
use Troulite\PathfinderBundle\Entity\ClassDefinition;

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
                $i = 0;
                $choices = array('other' => 'Other', 'allies' => 'Allies');
                if ($character->getParty()) {
                    foreach ($character->getParty()->getCharacters() as $ally) {
                        $choices[$ally->getId()] = $ally->getName();
                    }
                }

                foreach ($character->getPreparedSpells() as $preparedSpell) {
                    if (!$preparedSpell->isAlreadyCast()) {
                        $form->add(
                            $i++,
                            new CastPreparedSpellType(),
                            array(
                                'label'    => false,
                                'targets'  => $choices,
                                'mapped'   => false,
                                'spell'    => $preparedSpell->getSpell(),
                                'class'    => $preparedSpell->getClass(),
                                'required' => false
                            )
                        );
                    }
                }

                foreach ($character->getLevelPerClass() as $classLevel) {
                    /** @var $class ClassDefinition */
                    $class = $classLevel['class'];
                    /** @var $level int */
                    $level = $classLevel['level'];
                    if (!$class->isPreparationNeeded()) {
                        foreach ($class->getSpellsPerDay() as $spellLevel => $levels) {
                            $alreadyCast = $character->getNonPreparedCastSpellsCount();
                            $count = 0;
                            if (
                                $alreadyCast &&
                                array_key_exists($class->getId(), $alreadyCast) &&
                                array_key_exists($spellLevel, $alreadyCast[$class->getId()])
                            ) {
                                $count = $alreadyCast[$class->getId()][$spellLevel];
                            }

                            $canCastCount =
                                $levels[$level - 1] +
                                $this->extra_spells[$character->getModifierByAbility(
                                    $class->getCastingAbility()
                                )][$spellLevel];

                            for(; $count < $canCastCount; $count++) {
                                $form->add(
                                    $i++,
                                    new CastUnpreparedSpellType(),
                                    array(
                                        'label' => false,
                                        'targets'  => $choices,
                                        'class'    => $class,
                                        'caster' => $character,
                                        'spellLevel' => $spellLevel,
                                        'required' => false,
                                        'mapped' => false,
                                    )
                                );
                            }
                        }
                    }
                }

                if ($form->count() > 0) {
                    $form->add('Cast', 'submit');
                }
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
}
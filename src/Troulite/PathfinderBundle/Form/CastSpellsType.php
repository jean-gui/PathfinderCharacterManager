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

                $choices = array('other' => 'Other', 'allies' => 'Allies');
                foreach ($character->getParty()->getCharacters() as $ally) {
                    $choices[$ally->getId()] = $ally->getName();
                }

                foreach ($character->getPreparedSpells() as $preparedSpell) {
                    $toAdd = $preparedSpell->getCount() - $preparedSpell->getCastCount();

                    while ($toAdd > 0) {
                        $toAdd--;
                        $form->add(
                            'Prepared_' . $toAdd,
                            new CastPreparedSpellType(),
                            array(
                                'targets'  => $choices,
                                'mapped'   => false,
                                'spell'    => $preparedSpell->getSpell(),
                                'class'    => $preparedSpell->getClass(),
                                'required' => false
                            )
                        );
                    }
                }

                $i = 1;
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
                            for(; $count < $levels[$level-1]; $count++) {
                                $form->add(
                                    'Unprepared_' . $i++,
                                    new CastUnpreparedSpellType(),
                                    array(
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
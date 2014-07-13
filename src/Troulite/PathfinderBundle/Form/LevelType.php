<?php

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Entity\Abilities;

class LevelType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('extraHp')
            ->add('extraSkill')
            ->add('classDefinition')
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $level = $event->getData();
                $form  = $event->getForm();

                if ($level && $level->getCharacter()->getLevels()->count() > 0) {
                    $form->add('hpRoll');

                    if ($level->getCharacter()->getLevels()->count() % 4 == 0) {
                        $form->add(
                            'extraAbility',
                            'choice',
                            array('choices' => array(
                                Abilities::STRENGTH,
                                Abilities::DEXTERITY,
                                Abilities::CONSTITUTION,
                                Abilities::INTELLIGENCE,
                                Abilities::WISDOM,
                                Abilities::CHARISMA
                            ))
                        );
                    }
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
        return 'troulite_pathfinderbundle_level';
    }
}

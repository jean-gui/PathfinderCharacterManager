<?php

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClassDefinitionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('hpDice')
            ->add('skillPoints')
            ->add('bab')
            ->add('reflexes')
            ->add('fortitude')
            ->add('will')
            ->add('spellsPerDay');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Troulite\PathfinderBundle\Entity\ClassDefinition'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troulite_pathfinderbundle_classdefinition';
    }
}

<?php

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class AbilitiesType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class AbilitiesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('baseStrength', null, array('label' => 'strength'))
            ->add('baseDexterity', null, array('label' => 'dexterity'))
            ->add('baseConstitution', null, array('label' => 'constitution'))
            ->add('baseIntelligence', null, array('label' => 'intelligence'))
            ->add('baseWisdom', null, array('label' => 'wisdom'))
            ->add('baseCharisma', null, array('label' => 'charisma'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troulite\PathfinderBundle\Entity\Abilities'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troulite_pathfinderbundle_abilities';
    }
}

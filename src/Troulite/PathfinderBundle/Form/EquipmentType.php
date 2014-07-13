<?php

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EquipmentType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mainWeapon')
            ->add('offhandWeapon')
            ->add('body')
            ->add('leftFinger')
            ->add('rightFinger')
            ->add('feet')
            ->add('neck')
            ->add('back')
            ->add('head')
            ->add('belt')
            ->add('hands')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troulite\PathfinderBundle\Entity\Equipment'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troulite_pathfinderbundle_equipment';
    }
}
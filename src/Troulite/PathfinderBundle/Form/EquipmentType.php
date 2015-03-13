<?php

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Form\Type\EquippedItemType;

/**
 * Class EquipmentType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class EquipmentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('headband', new EquippedItemType())
            ->add('head', new EquippedItemType())
            ->add('eyes', new EquippedItemType())
            ->add('neck', new EquippedItemType())
            ->add('shoulders', new EquippedItemType())
            ->add('armor', new EquippedItemType())
            ->add('body', new EquippedItemType())
            ->add('chest', new EquippedItemType())
            ->add('belt', new EquippedItemType())
            ->add('mainWeapon', new EquippedItemType())
            ->add('offhandWeapon', new EquippedItemType())
            ->add('wrists', new EquippedItemType())
            ->add('hands', new EquippedItemType())
            ->add('leftFinger', new EquippedItemType())
            ->add('rightFinger', new EquippedItemType())
            ->add('feet', new EquippedItemType())
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troulite\PathfinderBundle\Entity\CharacterEquipment'
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

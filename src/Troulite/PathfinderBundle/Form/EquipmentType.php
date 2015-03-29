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
            ->add('headband', new EquippedItemType(), array('label' => 'headband'))
            ->add('head', new EquippedItemType(), array('label' => 'head'))
            ->add('eyes', new EquippedItemType(), array('label' => 'eyes'))
            ->add('neck', new EquippedItemType(), array('label' => 'neck'))
            ->add('shoulders', new EquippedItemType(), array('label' => 'shoulders'))
            ->add('armor', new EquippedItemType(), array('label' => 'armor'))
            ->add('body', new EquippedItemType(), array('label' => 'body'))
            ->add('chest', new EquippedItemType(), array('label' => 'chest'))
            ->add('belt', new EquippedItemType(), array('label' => 'belt'))
            ->add('mainWeapon', new EquippedItemType(), array('label' => 'main.weapon'))
            ->add('offhandWeapon', new EquippedItemType(), array('label' => 'offhand.weapon'))
            ->add('wrists', new EquippedItemType(), array('label' => 'wrists'))
            ->add('hands', new EquippedItemType(), array('label' => 'hands'))
            ->add('leftFinger', new EquippedItemType(), array('label' => 'left.finger'))
            ->add('rightFinger', new EquippedItemType(), array('label' => 'right.finger'))
            ->add('feet', new EquippedItemType(), array('label' => 'feet'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troulite\PathfinderBundle\Entity\CharacterEquipment',
            'horizontal' => false
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

<?php

namespace App\Form;

use App\Entity\Characters\CharacterEquipment;
use App\Form\Type\EquippedItemType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EquipmentType
 *
 * @package App\Form
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
            ->add('headband', EquippedItemType::class, array('label' => 'headband'))
            ->add('head', EquippedItemType::class, array('label' => 'head'))
            ->add('eyes', EquippedItemType::class, array('label' => 'eyes'))
            ->add('neck', EquippedItemType::class, array('label' => 'neck'))
            ->add('shoulders', EquippedItemType::class, array('label' => 'shoulders'))
            ->add('armor', EquippedItemType::class, array('label' => 'armor'))
            ->add('body', EquippedItemType::class, array('label' => 'body'))
            ->add('chest', EquippedItemType::class, array('label' => 'chest'))
            ->add('belt', EquippedItemType::class, array('label' => 'belt'))
            ->add('mainWeapon', EquippedItemType::class, array('label' => 'main.weapon'))
            ->add('offhandWeapon', EquippedItemType::class, array('label' => 'offhand.weapon'))
            ->add('wrists', EquippedItemType::class, array('label' => 'wrists'))
            ->add('hands', EquippedItemType::class, array('label' => 'hands'))
            ->add('leftFinger', EquippedItemType::class, array('label' => 'left.finger'))
            ->add('rightFinger', EquippedItemType::class, array('label' => 'right.finger'))
            ->add('feet', EquippedItemType::class, array('label' => 'feet'))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CharacterEquipment::class,
            'horizontal' => false
        ));
    }
}

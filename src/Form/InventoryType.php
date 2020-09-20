<?php

namespace App\Form;

use App\Entity\Characters\Character;
use App\Form\Type\EquipmentInventoryItemType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class InventoryType
 *
 * @package App\Form
 */
class InventoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'unequipped_inventory',
                CollectionType::class,
                array(
                    'entry_type' => EquipmentInventoryItemType::class,
                    'label' => false,
                )
            )
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Character::class,
            'horizontal' => false
        ));
    }
}

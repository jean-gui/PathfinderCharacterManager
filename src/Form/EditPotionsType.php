<?php

namespace App\Form;

use App\Entity\Characters\Character;
use App\Form\Type\EditInventoryItemType;
use App\Form\Type\EditInventoryPotionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditPotionsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'potions',
                CollectionType::class,
                [
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'by_reference'  => false,
                    'entry_type'    => EditInventoryPotionType::class,
                    'label'         => 'potions',
                    'entry_options' => ['label' => false, 'attr' => ['class' => 'entry']],
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Character::class,
            ]
        );
    }
}

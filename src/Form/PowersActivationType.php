<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PowersActivationType
 *
 * @package App\Form
 */
class PowersActivationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('feats', CollectionType::class, ['entry_type' => FeatActivationType::class])
            ->add('class_powers', CollectionType::class, ['entry_type' => ClassPowerActivationType::class])
            ->add('spell_effects', CollectionType::class, ['entry_type' => SpellEffectActivationType::class])
            ->add('power_effects', CollectionType::class, ['entry_type' => PowerEffectActivationType::class])
            ->add('item_power_effects', CollectionType::class, ['entry_type' => ItemPowerEffectActivationType::class])
            ->add('submit', SubmitType::class, ['label' => '(De)Activate Powers']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['horizontal' => false, 'csrf_protection' => false]
        );
    }
} 
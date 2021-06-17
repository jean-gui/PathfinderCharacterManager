<?php

namespace App\Form;

use App\Entity\Characters\Character;
use App\Entity\Rules\CommonPower;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('feats', CollectionType::class, ['entry_type' => FeatActivationType::class, 'mapped' => false])
            ->add(
                'class_powers',
                CollectionType::class,
                [
                    'entry_type' => ClassPowerActivationType::class,
                    'mapped'     => false,
                ]
            )
            ->add(
                'spell_effects',
                CollectionType::class,
                [
                    'entry_type' => SpellEffectActivationType::class,
                    'mapped'     => false,
                ]
            )
            ->add(
                'power_effects',
                CollectionType::class,
                [
                    'entry_type' => PowerEffectActivationType::class,
                    'mapped'     => false,
                ]
            )
            ->add(
                'item_power_effects',
                CollectionType::class,
                [
                    'entry_type' => ItemPowerEffectActivationType::class,
                    'mapped'     => false,
                ]
            )
            ->add(
                'potion_effects',
                CollectionType::class,
                [
                    'entry_type' => PotionEffectActivationType::class,
                    'mapped'     => false,
                ]
            )
            ->add(
                'common_powers',
                EntityType::class,
                [
                    'class'    => CommonPower::class,
                    'multiple' => true,
                    'expanded'
                               => true,
                ]
            )
            ->add('submit', SubmitType::class, ['label' => '(De)Activate Powers']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => Character::class, 'horizontal' => false, 'csrf_protection' => false]
        );
    }
}

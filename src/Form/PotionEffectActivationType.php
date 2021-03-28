<?php

namespace App\Form;

use App\Entity\Characters\PotionEffect;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SpellEffectActivationType
 *
 * @package App\Form
 */
class PotionEffectActivationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'active',
                null,
                ["required" => false, 'translation_domain' => 'spells']
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => PotionEffect::class,
            ]
        );
    }
}

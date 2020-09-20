<?php

namespace App\Form;

use App\Entity\Characters\ItemPowerEffect;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ItemPowerEffectActivationType
 *
 * @package App\Form
 */
class ItemPowerEffectActivationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'active',
                null,
                array("required" => false, 'translation_domain' => 'itempowers')
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => ItemPowerEffect::class,
            )
        );
    }
}

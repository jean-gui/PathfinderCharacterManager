<?php

namespace App\Form;

use App\Entity\Characters\PowerEffect;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PowerEffectActivationType
 *
 * @package App\Form
 */
class PowerEffectActivationType extends AbstractType
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
                array("required" => false, 'translation_domain' => 'classpowers')
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => PowerEffect::class,
            )
        );
    }
}

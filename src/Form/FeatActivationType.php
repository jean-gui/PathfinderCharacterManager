<?php

namespace App\Form;

use App\Entity\Characters\CharacterFeat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FeatActivationType
 *
 * @package App\Form
 */
class FeatActivationType extends AbstractType
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
                array("required" => false, 'horizontal_input_wrapper_class' => null, 'translation_domain' => 'feats')
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => CharacterFeat::class,
            )
        );
    }
}

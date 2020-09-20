<?php

namespace App\Form;

use App\Entity\Characters\CharacterFeat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CharacterFeatType
 *
 * @package App\Form
 */
class CharacterFeatType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('active', null, array("required" => false))
            ->add('character')
            ->add('feat');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => CharacterFeat::class]
        );
    }
}

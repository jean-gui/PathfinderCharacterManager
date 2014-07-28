<?php

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class SpellEffectActivationType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class SpellEffectActivationType extends AbstractType
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
                array("required" => false)
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Troulite\PathfinderBundle\Entity\SpellEffect'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'spelleffectactivation';
    }
}

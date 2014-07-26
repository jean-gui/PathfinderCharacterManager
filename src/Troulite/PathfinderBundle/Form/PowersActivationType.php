<?php

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class PowersActivationType
 *
 * @package Troulite\PathfinderBundle\Form
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
            ->add('feats', 'collection', ['type' => new FeatActivationType()])
            ->add('class_powers', 'collection', ['type' => new ClassPowerActivationType()])
            ->add('submit', 'submit', ['label' => '(De)Activate Powers']);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'classpoweractivation';
    }

} 
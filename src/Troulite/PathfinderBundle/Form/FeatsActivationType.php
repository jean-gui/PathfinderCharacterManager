<?php

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FeatsActivationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('feats', 'collection', ['type' => new FeatActivationType()])
            ->add('submit', 'submit', ['label' => '(De)Activate Feats']);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Troulite\PathfinderBundle\Entity\BaseCharacter'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'featsactivation';
    }

} 
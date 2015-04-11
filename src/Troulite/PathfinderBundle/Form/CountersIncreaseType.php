<?php

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CountersIncreaseType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class CountersIncreaseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'counters',
                'collection',
                array(
                    'type' => new CounterIncreaseType(),
                    'label_render' => false,
                )
            )
            ->add('increase_all', 'submit', array('icon' => 'menu-up'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troulite\PathfinderBundle\Entity\Character'
        ));
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'troulite_pathfinderbundle_countersincrease';
    }
}

<?php

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Form\Classes\ClassPowerType;

class SubClassType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('shortDescription')
            ->add('longDescription')
            ->add('parent')
            ->add(
                'powers',
                'collection',
                array(
                    'type'                           => new ClassPowerType(),
                    'allow_add'                      => true,
                    'allow_delete'                   => true,
                    'by_reference'                   => false,
                    'horizontal_label_class'         => 'col-sm-2',
                    'horizontal_input_wrapper_class' => 'col-sm-10',
                    'options'                        => array(
                        'horizontal_label_class' => 'col-sm-2',
                        'label_render'           => false
                    )
                )
            );
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troulite\PathfinderBundle\Entity\SubClass'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troulite_pathfinderbundle_subclass';
    }
}

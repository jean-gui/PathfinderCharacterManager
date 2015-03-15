<?php

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class EditInventoryType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class EditInventoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'inventory',
                'collection',
                array(
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'type'         => 'entity',
                    'label'        => false,
                    'options'      => array('class' => 'Troulite\PathfinderBundle\Entity\Item', 'label' => false)
                )
            )
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
        return 'troulite_pathfinderbundle_inventory';
    }
}

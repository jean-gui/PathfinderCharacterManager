<?php

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class PartyLogbookType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class PartyLogbookType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'logbook',
                new LogbookType(),
                array(
                    'label_render'                   => false,
                    'horizontal_input_wrapper_class' => false,
                    'horizontal_label_class'         => false,
                    'horizontal_label_offset_class'  => false,
                )
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Troulite\PathfinderBundle\Entity\Party'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troulite_pathfinderbundle_partylogbook';
    }
}

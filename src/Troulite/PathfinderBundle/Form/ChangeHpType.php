<?php

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ChangeHpType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class ChangeHpType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'hp_mod',
                'integer',
                array(
                    'label'  => /** @Ignore */ false,
                    'mapped' => false,
                    'horizontal_input_wrapper_class' => 'col-xs-5',
                    'widget_form_group_attr' => array('class' => false),
                    'widget_form_group' => false
                )
            )
            ->add('submit', 'submit', array('label' => 'heal.harm'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troulite\PathfinderBundle\Entity\Character',
            'widget_form_group' => true,
            'widget_form_group_attr' => array('class' => 'row')
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troulite_pathfinderbundle_changehitpoints';
    }
}

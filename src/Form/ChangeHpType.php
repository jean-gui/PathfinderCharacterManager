<?php

namespace App\Form;

use App\Entity\Characters\Character;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ChangeHpType
 *
 * @package App\Form
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
                IntegerType::class,
                array(
                    'label'  => false,
                    'mapped' => false,
                )
            )
            ->add('submit', SubmitType::class, array('label' => 'heal.harm'))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Character::class,
            'widget_form_group' => true,
            'widget_form_group_attr' => array('class' => 'row')
        ));
    }
}

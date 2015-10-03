<?php

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Troulite\PathfinderBundle\Form\DataTransformer\ArrayToJsonTransformer;


class ConditionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('shortDescription', null, array('attr' => array('class' => 'wysiwyg')))
            ->add('longDescription', null, array('attr' => array('class' => 'wysiwyg')))
            ->add($builder->create('effects', 'textarea', array(
                'required' => false,
                'attr'     => array('class' => 'code-json')
            ))
                ->addModelTransformer(new ArrayToJsonTransformer())
            )
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troulite\PathfinderBundle\Entity\Condition'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troulite_pathfinderbundle_condition';
    }
}

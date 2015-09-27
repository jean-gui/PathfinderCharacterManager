<?php

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
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
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
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

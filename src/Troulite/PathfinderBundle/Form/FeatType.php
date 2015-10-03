<?php

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Troulite\PathfinderBundle\Form\DataTransformer\ArrayToJsonTransformer;

class FeatType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $arrayToJsonTransformer = new ArrayToJsonTransformer();

        $builder
            ->add('name')
            ->add('shortDescription', null, array('attr' => array('class' => 'wysiwyg')))
            ->add('longDescription', null, array('attr' => array('class' => 'wysiwyg')))
            ->add('passive', null, array('required' => false))
            ->add(
                $builder->create(
                    'effects',
                    'textarea',
                    array('required' => false, 'attr' => array('class' => 'code-json')))
                    ->addModelTransformer($arrayToJsonTransformer)
            )
            ->add(
                $builder->create('conditions', 'textarea', array(
                    'required' => false,
                    'attr'     => array('class' => 'code-json')
                ))
                    ->addModelTransformer($arrayToJsonTransformer)
            )
            ->add(
                $builder->create('externalConditions', 'textarea', array(
                    'required' => false,
                    'attr'     => array('class' => 'code-json')
                ))
                    ->addModelTransformer($arrayToJsonTransformer)
            )
            ->add(
                $builder->create('prerequisities', 'textarea', array(
                    'required' => false,
                    'attr'     => array('class' => 'code-json')
                ))
                    ->addModelTransformer($arrayToJsonTransformer)
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troulite\PathfinderBundle\Entity\Feat'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troulite_pathfinderbundle_feat';
    }
}

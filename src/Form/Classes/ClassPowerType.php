<?php

namespace App\Form\Classes;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Entity\Rules\ClassPower;
use App\Form\DataTransformer\ArrayToJsonTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ClassPowerType
 *
 * @package App\Form\Classes
 */
class ClassPowerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $arrayToJsonTransformer = new ArrayToJsonTransformer();

        $builder
            ->add('translations', TranslationsType::class, ['label' => false])
            ->add('level')
            ->add('castable', null, ['required' => false])
            ->add('passive', null, ['required' => false])
            ->add(
                $builder->create(
                    'prerequisities',
                    TextareaType::class,
                    [
                        'required' => false,
                        'attr'     => ['class' => 'code-json']
                    ]
                )
                        ->addModelTransformer($arrayToJsonTransformer)
            )
            ->add(
                $builder->create(
                    'conditions',
                    TextareaType::class,
                    [
                        'required' => false,
                        'attr'     => ['class' => 'code-json']
                    ]
                )
                        ->addModelTransformer($arrayToJsonTransformer)
            )
            ->add(
                $builder->create(
                    'externalConditions',
                    TextareaType::class,
                    [
                        'required' => false,
                        'attr'     => ['class' => 'code-json']
                    ]
                )
                        ->addModelTransformer($arrayToJsonTransformer)
            )
            ->add(
                $builder->create(
                    'effects',
                    TextareaType::class,
                    [
                        'required' => false,
                        'attr'     => ['class' => 'code-json']
                    ]
                )
                        ->addModelTransformer($arrayToJsonTransformer)
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => ClassPower::class
            ]
        );
    }
}

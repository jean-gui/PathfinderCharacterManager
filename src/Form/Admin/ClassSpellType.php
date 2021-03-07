<?php

namespace App\Form\Admin;

use App\Entity\Rules\ClassSpell;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClassSpellType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('class', null, ['help' => 'If subclass is selected, class will be ignored'])
            ->add('subClass')
            ->add('spellLevel');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => ClassSpell::class,
            ]
        );
    }
}

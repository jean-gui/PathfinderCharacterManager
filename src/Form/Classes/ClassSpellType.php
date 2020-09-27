<?php

namespace App\Form\Classes;

use App\Entity\Rules\ClassSpell;
use App\Entity\Rules\Spell;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ClassSpellType
 *
 * @package App\Form\Classes
 */
class ClassSpellType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'spell',
                EntityType::class,
                [
                    'class'       => Spell::class,
                    'choice_name' => ChoiceList::fieldName($this,'name'),
                    'attr'        => ['class' => 'select2']
                ]
            )
            ->add('spellLevel', null,
                array(
                    'required' => false,
                    'label' => false,
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => ClassSpell::class
            )
        );
    }
}

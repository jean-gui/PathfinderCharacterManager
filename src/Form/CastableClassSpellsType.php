<?php

namespace App\Form;

use App\Model\CastableClassSpells;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CastableClassSpellsType
 *
 * @package App\Form
 */
class CastableClassSpellsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'spells_by_level',
            CollectionType::class,
            array(
                'entry_type' => CastSpellsLevelType::class,
                'entry_options' => array(
                    'caster'  => $options['caster'],
                    'targets' => $options['targets'],
                ),
                'label' => false,
                'required' => false
            )
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(array('caster', 'targets'));
        $resolver->setDefaults(array('data_class' => CastableClassSpells::class));
    }
}

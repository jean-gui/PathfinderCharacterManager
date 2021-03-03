<?php

namespace App\Form;

use App\Entity\Characters\Character;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrepareSpellsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'preparedSpells',
            CollectionType::class,
            [
                'label'         => 'Prepare Spells',
                'entry_type'    => PreparedSpellType::class,
                'entry_options' => [
                    'disable_not_empty' => $options['disable_not_empty']
                ]
            ]
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'        => Character::class,
                'disable_not_empty' => false
            ]
        );
    }
}

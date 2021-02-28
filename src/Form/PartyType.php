<?php

namespace App\Form;

use App\Entity\Party;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PartyType
 *
 * @package App\Form
 */
class PartyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'party.name'])
            ->add('dungeonMaster', null, ['label' => 'party.dm'])
            ->add(
                'discordDsn',
                UrlType::class,
                [
                    'default_protocol' => 'discord',
                    'label'            => 'party.discord_dsn.label',
                    'help'             => 'party.discord_dsn.help'
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => Party::class
            )
        );
    }
}

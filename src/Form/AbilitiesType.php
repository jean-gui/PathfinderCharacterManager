<?php

namespace App\Form;

use App\Entity\Rules\Abilities;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbilitiesType
 *
 * @package App\Form
 */
class AbilitiesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('baseStrength', null, array('label' => 'strength'))
            ->add('baseDexterity', null, array('label' => 'dexterity'))
            ->add('baseConstitution', null, array('label' => 'constitution'))
            ->add('baseIntelligence', null, array('label' => 'intelligence'))
            ->add('baseWisdom', null, array('label' => 'wisdom'))
            ->add('baseCharisma', null, array('label' => 'charisma'))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Abilities::class
        ));
    }
}

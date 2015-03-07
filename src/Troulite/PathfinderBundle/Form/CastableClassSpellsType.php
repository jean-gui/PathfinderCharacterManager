<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 02/08/14
 * Time: 17:05
 */

namespace Troulite\PathfinderBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CastableClassSpellsType
 *
 * @package Troulite\PathfinderBundle\Form
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
            'collection',
            array(
                'type' => new CastSpellsLevelType(),
                'options' => array(
                    'caster'  => $options['caster'],
                    'targets' => $options['targets'],
                ),
                'label' => false,
            )
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array('caster', 'targets'));
        $resolver->setDefaults(array('data_class' => 'Troulite\PathfinderBundle\Model\CastableClassSpells'));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'troulite_pathfinder_bundle_castable_class_spells';
    }
}
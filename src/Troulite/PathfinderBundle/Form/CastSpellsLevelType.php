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
 * Class CastSpellsLevelType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class CastSpellsLevelType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'spells',
            'collection',
            array(
                'type'    => new CastSpellType(),
                'options' => array('targets' => $options['targets'], 'caster' => $options['caster']),
                'label'   => /** @Ignore */ false,
                'required' => false
            )
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array('caster', 'targets'));
        $resolver->setDefaults(array('data_class' => 'Troulite\PathfinderBundle\Model\CastableLevelSpells'));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'troulite_pathfinder_bundle_cast_spells_level';
    }
}
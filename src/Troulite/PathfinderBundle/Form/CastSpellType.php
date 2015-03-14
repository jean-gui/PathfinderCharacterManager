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
 * Class CastSpellType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class CastSpellType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'targets',
                'choice',
                array(
                    'choices'     => $options['targets'],
                    'empty_value' => 'Target',
                    'mapped'      => false,
                    'required'    => false,
                )
            )
            ->add('id', 'submit', array('label' => 'cast'));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troulite\PathfinderBundle\Entity\Spell',
        ));
        $resolver->setRequired(array('caster', 'targets'));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'troulite_pathfinderbundle_cast_spell';
    }
}
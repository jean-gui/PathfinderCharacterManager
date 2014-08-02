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
use Troulite\PathfinderBundle\Entity\Character;
use Troulite\PathfinderBundle\Entity\ClassSpell;

/**
 * Class CastUnreparedSpellType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class CastUnpreparedSpellType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var $caster Character */
        $caster = $options['caster'];
        $spells = array_filter(
            $caster->getLearnedSpells(),
            function (ClassSpell $cs) use ($options) {
                return $cs->getClass() === $options['class'] && $cs->getSpellLevel() === $options['spellLevel'];
            });

        $builder
            ->add(
                'spell',
                'entity',
                array(
                    'choices' => $spells,
                    'class'    => 'TroulitePathfinderBundle:ClassSpell',
                    'property' => 'spell',
                )
            )
            ->add(
                'targets',
                'choice',
                array(
                    'label'       => $options['class'] . ' Level' . $options['spellLevel'],
                    'choices'     => $options['targets'],
                    'empty_value' => 'Target'
                )
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array('caster', 'targets', 'class', 'spellLevel'));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'troulite_pathfinder_bundle_cast_unprepared_spells';
    }
}
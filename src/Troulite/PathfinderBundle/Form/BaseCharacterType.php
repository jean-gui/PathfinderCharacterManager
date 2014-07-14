<?php

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class BaseCharacterType
 *
 * @package Troulite\PathfinderBundle\Form
 * @todo For some reason, xdebug.max_nesting_level needs to be set to at least 104 in dev environment
 */
class BaseCharacterType extends AbstractType
{
    /**
     * @var
     */
    private $advancement;

    /**
     * @param $advancement
     */
    public function __construct($advancement)
    {
        $this->advancement = $advancement;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('race')
            ->add('favoredClass')
            ->add('extraPoint', 'choice', array('choices' => array('hp' => 'Hit Point', 'skill' => 'Skill')))
            ->add('abilities', new AbilitiesType())
            ->add(
                'levels',
                'collection',
                array(
                    'type' => new LevelType($this->advancement),
                    'options' => array('label' => false),
                    'label' => false
                )
            )
            ->add('equipment', new EquipmentType())
            ->add('party')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troulite\PathfinderBundle\Entity\BaseCharacter'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troulite_pathfinderbundle_basecharacter';
    }
}

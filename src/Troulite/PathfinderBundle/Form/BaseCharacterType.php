<?php

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BaseCharacterType extends AbstractType
{
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
                array('type' => new LevelType(), 'allow_add' => true))
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

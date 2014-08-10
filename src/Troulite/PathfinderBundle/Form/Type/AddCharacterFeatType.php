<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 14/07/14
 * Time: 21:25
 */

namespace Troulite\PathfinderBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
//use Troulite\PathfinderBundle\Form\DataTransformer\FeatToCharacterFeatTransformer;

/**
 * Class AddCharacterFeatType
 *
 * @package Troulite\PathfinderBundle\Form\Type
 */
class AddCharacterFeatType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$featTransformer = new FeatToCharacterFeatTransformer($options['level']);
        //$builder->addModelTransformer($featTransformer);

        $builder->add(
            'feat',
            'entity',
            array(
                'class'   => 'TroulitePathfinderBundle:Feat',
                'choices' => $options['choices'][$builder->getName()]
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'addcharacterfeat';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Troulite\PathfinderBundle\Entity\CharacterFeat'
            )
        );
        $resolver->setRequired(array('level', 'choices'));
    }


} 
<?php

namespace App\Form;

use App\Entity\Characters\Character;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BaseCharacterType
 *
 * @package App\Form
 */
class BaseCharacterType extends AbstractType
{
    /**
     * @var
     */
    protected $advancement;

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
            ->add('abilities', AbilitiesType::class)
            ->add('party')
            ->add('color', ColorType::class, ['required' => true, 'html5' => true])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Character::class
        ));
    }
}

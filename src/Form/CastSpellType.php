<?php


namespace App\Form;


use App\Entity\Rules\Spell;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CastSpellType
 *
 * @package App\Form
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
                ChoiceType::class,
                array(
                    'choices'     => $options['targets'],
                    'placeholder' => 'Target',
                    'mapped'      => false,
                    'required'    => false,
                    'multiple'    => true,
                    'attr'        => ['data-controller' => 'select2']
                )
            )
            ->add('id', SubmitType::class, array('label' => 'cast'));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => Spell::class));
        $resolver->setRequired(array('caster', 'targets'));
    }
}
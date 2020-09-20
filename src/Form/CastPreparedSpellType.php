<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CastPreparedSpellType
 *
 * @package App\Form
 */
class CastPreparedSpellType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'targets',
            ChoiceType::class,
            array(
                'label'       => $options['spell'] . ' (' . $options['class'] . ')',
                'choices'     => $options['targets'],
                'placeholder' => 'Target'
            )
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(array('targets', 'spell', 'class'));
    }
}
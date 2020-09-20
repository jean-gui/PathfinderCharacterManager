<?php

namespace App\Form\Notes;

use App\Entity\Characters\Character;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NotesType
 *
 * @package App\Form\Notes
 */
class NotesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'notes',
                TextareaType::class,
                array(
                    'property_path' => $options['type'] . 'Notes',
                    'required'      => false,
                )
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Character::class,
            'type'       => 'general'
        ));
        $resolver->setAllowedValues('type', array('general', 'power', 'inventory', 'spell'));
    }

    /**
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['htmlid'] = $options['type'] . 'Notes';
        $view->vars['type'] = $options['type'];
    }
}

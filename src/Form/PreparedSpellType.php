<?php

namespace App\Form;

use App\Entity\Characters\PreparedSpell;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class PreparedSpellType
 *
 * @package App\Form
 */
class PreparedSpellType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $translator = $this->translator;
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($options, $translator) {
                $form          = $event->getForm();

                $allChoices = $options['choices'];
                $slotNumber = (int) $form->getName();

                // Compute spell level and pick the right choice list from $allChoices
                $choices = $allChoices[$slotNumber];

                $choicesKeys = array_map(
                    function ($level) use ($translator) {
                        return $translator->trans('sleep.spell.level', ['%level%' => $level]);
                    },
                    array_keys($choices)
                );
                $choices = array_reverse(array_combine($choicesKeys, $choices));

                $form->add(
                    'spell',
                    null,
                    array(
                        'choices' => $choices,
                    )
                );
            }
        );
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $slotNumber = (int)$form->getName();
        $view->vars['level'] = max(array_keys($options['choices'][$slotNumber]));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PreparedSpell::class
        ));
        $resolver->setRequired(array('choices'));
    }
}

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
                /** @var PreparedSpell $preparedSpell */
                $preparedSpell = $event->getData();

                // Compute spell level and pick the right choice list from $allChoices
                $choices = $preparedSpell->getAvailableSpells();

                $choicesKeys = array_map(
                    function ($level) use ($translator) {
                        return $translator->trans('prepare_spells.spell.level', ['%level%' => $level]);
                    },
                    array_keys($choices)
                );
                $choices = array_combine($choicesKeys, $choices);

                $form->add(
                    'spell',
                    null,
                    array(
                        'choices' => $choices,
                        'attr'    => ['data-controller' => 'select2'],
                        'disabled' => $options['disable_not_empty'] && $preparedSpell->getSpell(),
                        'required' => false,
                        'placeholder' => 'prepare_spells.slot.leave_unprepared'
                    )
                );
            }
        );
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['level'] = $form->getData()->getLevel();
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PreparedSpell::class
        ));
        $resolver->setDefaults(['disable_not_empty' => false]);
    }
}

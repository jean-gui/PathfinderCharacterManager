<?php

namespace App\Form;

use App\Entity\Characters\PreparedSpell;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PreparedSpellType
 *
 * @package App\Form
 */
class PreparedSpellType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($options) {
                $form          = $event->getForm();

                $allChoices = $options['choices'];
                $slotNumber = (int) $form->getName();
                $level      = 0;
                $choices    = array();

                // Compute spell level and pick the right choice list from $allChoices
                foreach ($allChoices as $spellLevel => $slots) {
                    if ($slotNumber < count($slots)) {
                        $level = $spellLevel;
                        $choices = $slots[$slotNumber];
                        break;
                    } else {
                        $slotNumber -= count($slots);
                    }
                }

                $form->add(
                    'spell',
                    null,
                    array(
                        'label' => 'Level ' . $level . ' Slot',
                        'choices' => $choices,
                    )
                );
            }
        );
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

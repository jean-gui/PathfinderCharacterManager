<?php


namespace App\Form;

use App\Entity\Characters\Character;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UncastSpellsType
 *
 * @todo this whole class is extremely dirty
 *
 * @package App\Form
 */
class UncastSpellsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                /** @var $character Character */
                $character = $event->getData();
                $form      = $event->getForm();

                $i = 0;
                if ($character->getParty()) {
                    foreach ($character->getParty()->getCharacters() as $ally) {
                        foreach ($ally->getSpellEffects() as $spellEffect) {
                            if ($spellEffect->getCaster() === $character) {
                                $form->add(
                                    $i++,
                                    UncastSpellType::class,
                                    array(
                                        'mapped'      => false,
                                        // @todo Wow that's ugly!
                                        'label'       => $spellEffect->getSpell() . ' (' . $spellEffect->getCharacter() . ')',
                                        'spellEffect' => $spellEffect,
                                    )
                                );
                            }
                        }
                    }
                }

                if ($form->count() > 0) {
                    $form->add('Uncast', SubmitType::class, array('label' => 'uncast'));
                }
            }
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => Character::class
            )
        );
    }
}

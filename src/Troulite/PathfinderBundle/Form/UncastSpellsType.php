<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 02/08/14
 * Time: 19:35
 */

namespace Troulite\PathfinderBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Entity\Character;

/**
 * Class UncastSpellsType
 *
 * @package Troulite\PathfinderBundle\Form
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
                                    new UncastSpellType(),
                                    array(
                                        'mapped'      => false,
                                        'label'       => $spellEffect->getSpell() . ' on ' . $spellEffect->getCharacter(
                                            ),
                                        'spellEffect' => $spellEffect
                                    )
                                );
                            }
                        }
                    }
                }

                if ($form->count() > 0) {
                    $form->add('Uncast', 'submit', array('label' => 'uncast'));
                }
            }
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Troulite\PathfinderBundle\Entity\Character'
            )
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'troulite_pathfinder_bundle_uncast_spells';
    }
}
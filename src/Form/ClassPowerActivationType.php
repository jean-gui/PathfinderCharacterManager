<?php

namespace App\Form;

use App\Entity\Characters\CharacterClassPower;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ClassPowerActivationType
 *
 * @package App\Form
 */
class ClassPowerActivationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                /** @var $ccp CharacterClassPower */
                $ccp  = $event->getData();
                $form = $event->getForm();

                if ($ccp->getClassPower()->isCastable() && !$ccp->isActive()) {
                    $choices = array('Other' => 'other', 'Allies' => 'allies');
                    foreach ($ccp->getCharacter()->getParty()->getCharacters() as $ally) {
                        $choices[$ally->getName()] = $ally->getId();
                    }
                    $form->add(
                        'active',
                        ChoiceType::class,
                        array(
                            'choices'  => $choices,
                            'mapped'   => false,
                            'required' => false,
                            'multiple' => true,
                        )
                    )
                    ->add(
                        'cancel',
                        CheckboxType::class,
                        array(
                            'mapped' => false,
                            'required' => false,
                            'label_attr' => array('class' => null)
                        )
                    );
                } else {
                    $form->add(
                        'active',
                        null,
                        ["required" => false]
                    );
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
                'data_class' => CharacterClassPower::class
            )
        );
    }
}

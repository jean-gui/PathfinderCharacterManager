<?php

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Entity\CharacterClassPower;

/**
 * Class ClassPowerActivationType
 *
 * @package Troulite\PathfinderBundle\Form
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
                    $choices = array('other' => 'Other', 'allies' => 'Allies');
                    foreach ($ccp->getCharacter()->getParty()->getCharacters() as $ally) {
                        $choices[$ally->getId()] = $ally->getName();
                    }
                    $form->add(
                        'active',
                        'choice',
                        array(
                            'label'    => false,
                            'choices'  => $choices,
                            'mapped'   => false,
                            'required' => false
                        )
                    )
                    ->add(
                        'cancel',
                        'checkbox',
                        array(
                            'mapped' => false,
                            'required' => false
                        )
                    );
                } else {
                    $form->add(
                        'active',
                        null,
                        array("required" => false)
                    );
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
                'data_class' => 'Troulite\PathfinderBundle\Entity\CharacterClassPower'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'classpoweractivation';
    }
}

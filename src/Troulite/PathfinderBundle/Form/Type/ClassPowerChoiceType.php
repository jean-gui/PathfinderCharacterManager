<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 10/08/14
 * Time: 16:48
 */

namespace Troulite\PathfinderBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Entity\CharacterClassPower;

/**
 * Class ClassPowerChoiceType
 *
 * @package Troulite\PathfinderBundle\Form\Type
 */
class ClassPowerChoiceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($options) {
                /** @var $characterClassPower CharacterClassPower */
                $characterClassPower = $event->getData();
                $form      = $event->getForm();
                if (array_key_exists('choice', $characterClassPower->getClassPower()->getEffects())) {
                    $form->add(
                        'extraInformation',
                        'choice',
                        array(
                            /** @Ignore */
                            'label' => $characterClassPower->getClassPower(),
                            'choices' => array_combine(
                                $characterClassPower->getClassPower()->getEffects()['choice'],
                                $characterClassPower->getClassPower()->getEffects()['choice']
                            )
                        )
                    );
                }
            }
        );
    }

    /**
     * {@inheritdoc
     */
    public function getName()
    {
        return 'classpower_choice';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Troulite\PathfinderBundle\Entity\CharacterClassPower'
            )
        );
    }
}
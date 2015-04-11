<?php

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Entity\Character;

/**
 * Class CountersIncreaseType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class CountersIncreaseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'counters',
                'collection',
                array(
                    'type'         => new CounterIncreaseType(),
                    'label_render' => false,
                )
            );

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                /** @var $character Character */
                $character = $event->getData();
                $form      = $event->getForm();

                if ($character->getCounters()->count() > 0) {
                    $form->add('increase_all', 'submit', array('icon' => 'menu-up'));
                }
            }
        );
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troulite\PathfinderBundle\Entity\Character'
        ));
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'troulite_pathfinderbundle_countersincrease';
    }
}

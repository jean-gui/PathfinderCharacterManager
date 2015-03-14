<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 14/07/14
 * Time: 21:25
 */

namespace Troulite\PathfinderBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Entity\Item;

/**
 * Class InventoryItemType
 *
 * @package Troulite\PathfinderBundle\Form\Type
 */
class InventoryItemType extends AbstractType
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
                /** @var $item Item */
                $item = $event->getData();
                $form      = $event->getForm();

                if (get_class($item) !== 'Troulite\PathfinderBundle\Entity\Item') {
                    $form->add('equip', 'submit', array('label' => 'equip'));
                }
                $form->add('drop', 'submit', array('label' => 'drop'));
            }
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'unequippeditem';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Troulite\PathfinderBundle\Entity\Item'
            )
        );
    }
} 
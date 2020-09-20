<?php

namespace App\Form;

use App\Entity\Characters\CharacterEquipment;
use App\Entity\Items\Item;
use App\Form\Type\EquippedItemType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EquipmentType
 *
 * @package App\Form
 */
class EquipmentType extends AbstractType
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
                /** @var $characterEquipment CharacterEquipment */
                $characterEquipment = $event->getData();
                $form = $event->getForm();

                if ($characterEquipment->getMainWeapon()) {
                    $form->add('mainWeapon', EquippedItemType::class, ['label' => 'main.weapon']);
                }
                if ($characterEquipment->getOffhandWeapon()) {
                    $form->add('offhandWeapon', EquippedItemType::class, ['label' => 'offhand.weapon']);
                }
                if ($characterEquipment->getArmor()) {
                    $form->add('armor', EquippedItemType::class, ['label' => 'armor']);
                }
                if ($characterEquipment->getBelt()) {
                    $form->add('belt', EquippedItemType::class, ['label' => 'belt']);
                }
                if ($characterEquipment->getBody()) {
                    $form->add('body', EquippedItemType::class, ['label' => 'body']);
                }
                if ($characterEquipment->getChest()) {
                    $form->add('chest', EquippedItemType::class, ['label' => 'chest']);
                }
                if ($characterEquipment->getEyes()) {
                    $form->add('eyes', EquippedItemType::class, ['label' => 'eyes']);
                }
                if ($characterEquipment->getFeet()) {
                    $form->add('feet', EquippedItemType::class, ['label' => 'feet']);
                }
                if ($characterEquipment->getHands()) {
                    $form->add('hands', EquippedItemType::class, ['label' => 'hands']);
                }
                if ($characterEquipment->getHead()) {
                    $form->add('head', EquippedItemType::class, ['label' => 'head']);
                }
                if ($characterEquipment->getHeadband()) {
                    $form->add('headband', EquippedItemType::class, ['label' => 'headband']);
                }
                if ($characterEquipment->getLeftFinger()) {
                    $form->add('leftFinger', EquippedItemType::class, ['label' => 'left.finger']);
                }
                if ($characterEquipment->getRightFinger()) {
                    $form->add('rightFinger', EquippedItemType::class, ['label' => 'right.finger']);
                }
                if ($characterEquipment->getNeck()) {
                    $form->add('neck', EquippedItemType::class, ['label' => 'neck']);
                }
                if ($characterEquipment->getShoulders()) {
                    $form->add('shoulders', EquippedItemType::class, ['label' => 'shoulders']);
                }
                if ($characterEquipment->getWrists()) {
                    $form->add('wrists', EquippedItemType::class, ['label' => 'wrists']);
                }
            }
        );
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CharacterEquipment::class,
            'horizontal' => false
        ));
    }
}

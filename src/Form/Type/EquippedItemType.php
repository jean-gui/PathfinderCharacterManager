<?php


namespace App\Form\Type;

use App\Entity\Items\Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EquipmentInventoryItemType
 *
 * @package App\Form\Type
 */
class EquippedItemType extends AbstractType
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
                /** @var $item Item */
                $item = $event->getData();
                $form      = $event->getForm();

                if ($item) {
                    $form->add(
                        'unequip',
                        SubmitType::class,
                        ['label' => 'unequip']
                    );
                }
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Item::class,
            ]
        );
    }
}

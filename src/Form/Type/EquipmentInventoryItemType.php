<?php


namespace App\Form\Type;


use App\Entity\Characters\InventoryItem;
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
class EquipmentInventoryItemType extends AbstractType
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
                /** @var $item InventoryItem */
                $item = $event->getData();
                $form      = $event->getForm();

                if (get_class($item->getItem()) !== Item::class) {
                    $form->add('equip', SubmitType::class, array('label' => 'equip'));
                }
                $form->add('drop', SubmitType::class, array('label' => 'drop'));
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
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => InventoryItem::class
            )
        );
    }
} 
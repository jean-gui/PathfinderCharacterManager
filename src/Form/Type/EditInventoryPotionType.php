<?php

namespace App\Form\Type;

use App\Entity\Characters\InventoryPotion;
use App\Entity\Items\Potion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class EditInventoryPotionType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'potion',
                null,
                [
                    'choice_label' => function (Potion $potion) {
                        return $potion->__toString().' - '.$this->translator->trans('cl').' '.
                            $potion->getCasterLevel();
                    },
                    'attr'         => ['data-controller' => 'select2'],
                ]
            )
            ->add('quantity');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => InventoryPotion::class,
            ]
        );
    }
}

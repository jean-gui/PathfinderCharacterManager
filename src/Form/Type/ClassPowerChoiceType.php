<?php


namespace App\Form\Type;

use App\Entity\Characters\CharacterClassPower;
use App\Entity\Rules\ClassPower;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ClassPowerChoiceType
 *
 * @package App\Form\Type
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
                $effects = $characterClassPower->getClassPower()->getEffects();
                if ($effects && array_key_exists('choice', $effects)) {
                    $form->add(
                        'extraInformation',
                        ChoiceType::class,
                        [
                            'label' => $characterClassPower->getClassPower(),
                            'choices' => array_combine(
                                $characterClassPower->getClassPower()->getEffects()['choice'],
                                $characterClassPower->getClassPower()->getEffects()['choice']
                            ),
                            'attr'    => ['data-controller' => 'select2']
                        ]
                    );
                } elseif ($characterClassPower->getClassPower()->getChildren()->count() > 0) {
                    $form->add(
                        'childPower',
                        EntityType::class,
                        array(
                            'choices' => $characterClassPower->getClassPower()->getChildren(),
                            'class'   => ClassPower::class
                        )
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
            array(
                'data_class' => CharacterClassPower::class
            )
        );
    }
}
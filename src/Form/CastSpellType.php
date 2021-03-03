<?php


namespace App\Form;

use App\Entity\Rules\ClassDefinition;
use App\Entity\Rules\Spell;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

/**
 * Class CastSpellType
 *
 * @package App\Form
 */
class CastSpellType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'targets',
                ChoiceType::class,
                array(
                    'choices'     => $options['targets'],
                    'placeholder' => 'Target',
                    'mapped'      => false,
                    'required'    => false,
                    'multiple'    => true,
                    'attr'        => ['data-controller' => 'select2']
                )
            )
            ->add('id', SubmitType::class, array('label' => 'cast'));

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();

                /** @var ClassDefinition $class */
                $class = $form->getParent()->getParent()->getParent()->getParent()->getData()->getClass();
                /** @var int $level */
                $level = $form->getParent()->getParent()->getData()->getLevel();

                if (!$class->isPreparationNeeded()) {
                    $form->add(
                        'level',
                        IntegerType::class,
                        [
                            'mapped'      => false,
                            'data'        => $level,
                            'constraints' => new Range(['min' => $level, 'max' => 9]),
                            'attr'        => ['min' => $level, 'max' => 9]
                        ]
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
        $resolver->setDefaults(array('data_class' => Spell::class));
        $resolver->setRequired(array('caster', 'targets'));
    }
}

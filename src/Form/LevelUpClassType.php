<?php

namespace App\Form;

use App\Entity\Characters\Level;
use App\Entity\Rules\Abilities;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class LevelUpClassType
 *
 * @package App\Form
 */
class LevelUpClassType extends AbstractType
{
    /**
     * @var
     */
    protected $advancement;

    /**
     * @param $advancement
     */
    public function __construct($advancement)
    {
        $this->advancement = $advancement;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('classDefinition')
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                /** @var $level Level */
                $level     = $event->getData();
                $character = $level->getCharacter();
                $form      = $event->getForm();

                // Extra ability point
                if (
                    $level &&
                    $character->getLevel() > 0 &&
                    $this->advancement[$character->getLevel()]['ability']
                ) {
                    $form->add(
                        'extraAbility',
                        ChoiceType::class,
                        [
                            'choices' => [
                                Abilities::STRENGTH     => Abilities::STRENGTH,
                                Abilities::DEXTERITY    => Abilities::DEXTERITY,
                                Abilities::CONSTITUTION => Abilities::CONSTITUTION,
                                Abilities::INTELLIGENCE => Abilities::INTELLIGENCE,
                                Abilities::WISDOM       => Abilities::WISDOM,
                                Abilities::CHARISMA     => Abilities::CHARISMA
                            ],
                            'attr'    => ['data-controller' => 'select2']
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
        $resolver->setDefaults(array(
            'data_class' => Level::class
        ));
    }
}

<?php

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Entity\Abilities;
use Troulite\PathfinderBundle\Entity\Level;

/**
 * Class LevelUpClassType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class LevelUpClassType extends AbstractType
{
    /**
     * @var
     */
    private $advancement;

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
                        'choice',
                        array(
                            'choices' => array(
                                /** @Ignore */
                                Abilities::STRENGTH     => Abilities::STRENGTH,
                                /** @Ignore */
                                Abilities::DEXTERITY    => Abilities::DEXTERITY,
                                /** @Ignore */
                                Abilities::CONSTITUTION => Abilities::CONSTITUTION,
                                /** @Ignore */
                                Abilities::INTELLIGENCE => Abilities::INTELLIGENCE,
                                /** @Ignore */
                                Abilities::WISDOM       => Abilities::WISDOM,
                                /** @Ignore */
                                Abilities::CHARISMA     => Abilities::CHARISMA
                            )
                        )
                    );
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
            'data_class' => 'Troulite\PathfinderBundle\Entity\Level'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troulite_pathfinderbundle_level';
    }
}

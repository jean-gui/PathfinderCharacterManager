<?php

namespace App\Form;

use App\Entity\Characters\CharacterClassPower;
use App\Entity\Characters\Level;
use App\Form\Type\ClassPowerChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class LevelUpClassType
 *
 * @package App\Form
 */
class LevelUpClassSummaryHpType extends AbstractType
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
                /** @var $level Level */
                $level     = $event->getData();
                $character = $level->getCharacter();
                $classDefinition = $level->getClassDefinition();
                $classLevel = $character->getLevel($classDefinition);
                $classLevelPowers = $classDefinition->getPowers($classLevel);
                $form      = $event->getForm();

                // First level hpRoll should always be maxed out, so do not add the field in this case
                if ($character->getLevel() > 1) {
                    $form->add('hpRoll');
                }

                if ($character->getFavoredClass() === $level->getClassDefinition()) {
                    $form->add(
                        'extraPoint',
                        ChoiceType::class,
                        [
                            'choices' => ['Hit Point' => 'hp', 'Skill' => 'skill', 'Additional spell' => 'spell'],
                            'multiple' => true,
                            'required' => false
                        ]
                    );
                }

                // Class Powers requiring a choice
                $choices = null;
                foreach ($classLevelPowers as $power) {
                    $alreadyThere = false;
                    foreach ($level->getClassPowers() as $classPower) {
                        if ($classPower->getClassPower() === $power) {
                            $alreadyThere = true;
                            break;
                        }
                    }
                    if (
                        !$alreadyThere &&
                        (
                            ($power->getEffects() && array_key_exists('choice', $power->getEffects())) ||
                            ($power->getChildren()->count() > 0)
                        )
                    ) {
                        $level->addClassPower((new CharacterClassPower())->setClassPower($power));
                    }
                }

                $form->add(
                    'classPowers',
                    CollectionType::class,
                    array(
                        'label' => false,
                        'entry_type' => ClassPowerChoiceType::class,
                        'entry_options' => array('label' => false)
                    )
                );
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

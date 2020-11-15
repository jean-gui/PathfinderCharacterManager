<?php

namespace App\Form;

use App\Entity\Characters\Level;
use App\Entity\Characters\LevelSkill;
use App\Entity\Rules\Abilities;
use App\Entity\Rules\ClassSpell;
use App\Entity\Rules\Skill;
use App\Form\Type\AddCharacterSpellType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EditLevelType
 *
 * @package App\Form
 */
class EditLevelType extends AbstractType
{
    /**
     * @var
     */
    protected $advancement;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var Skill[]
     */
    protected $skills;

    /**
     * @param $advancement
     * @param EntityManagerInterface $em
     */
    public function __construct($advancement, EntityManagerInterface $em)
    {
        $this->advancement = $advancement;
        $this->em = $em;

        // TODO: order
        $this->skills = $this->em->getRepository(Skill::class)->findAll();
        usort($this->skills, function (Skill $s1, Skill $s2) {
            return strcmp($s1->name, $s2->name);
        });
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('hpRoll')
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                /** @var $level Level */
                $level     = $event->getData();
                $character = $level->getCharacter();
                $form      = $event->getForm();

                if ($character->getFavoredClass() === $level->getClassDefinition()) {
                    $form->add(
                        'extraPoint',
                        ChoiceType::class,
                        [
                            'choices'  => ['Hit Point' => 'hp', 'Skill' => 'skill', 'Additional spell' => 'spell'],
                            'multiple' => true,
                            'required' => false
                        ]
                    );
                }

                $levelValue = 0;
                foreach ($character->getLevels() as $key => $l) {
                    if ($l === $level) {
                        $levelValue = $key + 1;
                        break;
                    }
                }

                if (
                    $this->advancement[$levelValue]['ability']
                ) {
                    $form->add(
                        'extraAbility',
                        ChoiceType::class,
                        array(
                            'choices' => array(
                                Abilities::STRENGTH     => Abilities::STRENGTH,
                                Abilities::DEXTERITY    => Abilities::DEXTERITY,
                                Abilities::CONSTITUTION => Abilities::CONSTITUTION,
                                Abilities::INTELLIGENCE => Abilities::INTELLIGENCE,
                                Abilities::WISDOM       => Abilities::WISDOM,
                                Abilities::CHARISMA     => Abilities::CHARISMA
                            )
                        )
                    );
                }

                $learned = new ArrayCollection($level->getCharacter()->getLearnedSpells());
                $previousSpells = $level->getLearnedSpells();
                $level->setLearnedSpells(new ArrayCollection());
                foreach ($previousSpells as $previousSpell) {
                    $new = (new ClassSpell())
                        ->setSpell($previousSpell->getSpell())
                        ->setClass($previousSpell->getClass())
                        ->setSpellLevel($previousSpell->getSpellLevel());
                    $level->addLearnedSpell($new);
                    $learned->removeElement($previousSpell);
                }

                if ($level->getClassDefinition()->getKnownSpellsPerLevel()) {
                    $form->add(
                            'learnedSpells',
                            CollectionType::class,
                            array(
                                'label' => 'New Spell' . ($level->getLearnedSpells()->count() > 1 ? 's' : ''),
                                'entry_type' => AddCharacterSpellType::class,
                                'entry_options' => array(
                                    'learned' => $learned->toArray(),
                                    'em'      => $this->em,
                                    'class-definition' => $level->getClassDefinition(),
                                    'label'   => false
                                )
                            )
                    );
                }

                $skills = array();
                foreach ($level->getSkills() as $skill) {
                    $skills[$skill->getSkill()->getId()] = $skill;
                }
                $level->getSkills()->clear();

                if ($level->getSkills()->count() === 0) {
                    foreach ($this->skills as $skill) {
                        if (array_key_exists($skill->getId(), $skills)) {
                            $level->addSkill($skills[$skill->getId()]);
                        } else {
                            $level->addSkill(new LevelSkill($level, $skill));
                        }
                    }
                }
                $form->add(
                    'skills',
                    CollectionType::class,
                    array(
                        'entry_type'    => LevelSkillType::class,
                        'entry_options' => ['label' => false]
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

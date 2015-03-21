<?php

namespace Troulite\PathfinderBundle\Form;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Entity\Abilities;
use Troulite\PathfinderBundle\Entity\ClassSpell;
use Troulite\PathfinderBundle\Entity\Level;
use Troulite\PathfinderBundle\Entity\LevelSkill;
use Troulite\PathfinderBundle\Form\Type\AddCharacterSpellType;

/**
 * Class EditLevelType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class EditLevelType extends AbstractType
{
    /**
     * @var
     */
    private $advancement;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param $advancement
     * @param EntityManager $em
     */
    public function __construct($advancement, EntityManager $em)
    {
        $this->advancement = $advancement;
        $this->em = $em;

        $this->skills = $this->em->getRepository('TroulitePathfinderBundle:Skill')->findBy(
            array(),
            array('name' => 'ASC')
        );
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
                        'choice',
                        array('choices' => array('hp' => 'Hit Point', 'skill' => 'Skill'))
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
                        'choice',
                        array(
                            'choices' => array(
                                Abilities::STRENGTH     => mb_convert_case(Abilities::STRENGTH, MB_CASE_TITLE),
                                Abilities::DEXTERITY    => mb_convert_case(Abilities::DEXTERITY, MB_CASE_TITLE),
                                Abilities::CONSTITUTION => mb_convert_case(Abilities::CONSTITUTION, MB_CASE_TITLE),
                                Abilities::INTELLIGENCE => mb_convert_case(Abilities::INTELLIGENCE, MB_CASE_TITLE),
                                Abilities::WISDOM       => mb_convert_case(Abilities::WISDOM, MB_CASE_TITLE),
                                Abilities::CHARISMA     => mb_convert_case(Abilities::CHARISMA, MB_CASE_TITLE)
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
                            'collection',
                            array(
                                'label' => 'New Spell' . ($level->getLearnedSpells()->count() > 1 ? 's' : ''),
                                'type' => new AddCharacterSpellType(),
                                'options' => array(
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
                    'collection',
                    array(
                        'type'    => new LevelSkillType(),
                        'attr'    => array('class' => 'table table-hover table-striped table-condensed table-responsive'),
                        'options' => array('label' => false)
                    )
                );
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
        return 'troulite_pathfinderbundle_level_edit';
    }
}

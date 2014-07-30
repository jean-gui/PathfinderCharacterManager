<?php

namespace Troulite\PathfinderBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Entity\ClassSpell;
use Troulite\PathfinderBundle\Entity\Level;
use Troulite\PathfinderBundle\Form\Type\AddCharacterSpellType;

/**
 * Class LevelUpSpellsType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class LevelUpSpellsType extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $this->em;
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($em) {
                /** @var $level Level */
                $level = $event->getData();
                $character = $level->getCharacter();
                $class = $level->getClassDefinition();
                $classLevel = $character->getLevel($class);
                $form  = $event->getForm();

                if ($class && $class->getKnownSpellsPerLevel()) {
                    $learned = $character->getLearnedSpells();
                    array_walk($learned, function (ClassSpell $s) {
                        return $s->getId();
                    });
                    $spellLevels = array();
                    foreach ($class->getKnownSpellsPerLevel() as $spellLevel => $known) {
                        $spellsToAdd = $known[$classLevel - 1];
                        if ($classLevel > 1) {
                            $spellsToAdd -= $known[$classLevel - 2];
                        }

                        $spellsToAdd -= $level->getLearnedSpells()->count();

                        if ($spellsToAdd === 0) {
                            continue;
                        }

                        $spellLevels[] = $spellLevel;

                        while ($spellsToAdd > 0) {
                            $level->addLearnedSpell((new ClassSpell())->setClass($class)->setSpellLevel($spellLevel));
                            $spellsToAdd--;
                        }
                    }

                    $form->add(
                        'learnedSpells',
                        'collection',
                        array(
                            'label'   => 'New Spells',
                            'type'    => new AddCharacterSpellType(),
                            'options' => array(
                                'learned' => $learned,
                                'em'      => $em,
                                'class-definition' => $class
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
        return 'troulite_pathfinderbundle_levelspells';
    }
}

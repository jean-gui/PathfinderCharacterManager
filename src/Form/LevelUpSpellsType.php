<?php

namespace App\Form;

use App\Entity\Characters\Level;
use App\Entity\Rules\ClassSpell;
use App\Form\Type\AddCharacterSpellType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class LevelUpSpellsType
 *
 * @package App\Form
 */
class LevelUpSpellsType extends AbstractType
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
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
                /*
                 * "When a new loremaster level is gained, the character gains new spells per day as if he had also
                 * gained a level in a spellcasting class he belonged to before adding the prestige class. He does not,
                 * however, gain other benefits a character of that class would have gained, except for additional
                 * spells per day, spells known (if he is a spontaneous spellcaster), and an increased effective level
                 * of spellcasting."
                 */
                if ($class->isPrestige() && $level->getParentClass() && !$level->getParentClass()->isPreparationNeeded()) {
                    $class = $level->getParentClass();
                    $classLevel += $character->getLevel($level->getParentClass());
                }
                $form  = $event->getForm();

                if ($class && $class->getKnownSpellsPerLevel()) {
                    /*
                     * Tracks if ClassSpell entities are actually being created, useful to know if such entities have
                     * already been added previously
                     */
                    $spellsAdded = false;
                    $learned = $character->getLearnedSpells();
                    array_walk($learned, function (ClassSpell $s) {
                        return $s->getId();
                    });

                    $maxSpellLevel = 0;
                    foreach ($class->getKnownSpellsPerLevel() as $spellLevel => $known) {
                        if ($known[$classLevel - 1] > 0 && $spellLevel > $maxSpellLevel) {
                            $maxSpellLevel = $spellLevel;
                        }

                        $spellsToAdd = $known[$classLevel - 1];

                        if ($classLevel > 1) {
                            $spellsToAdd -= $known[$classLevel - 2];
                        }

                        // We don't want to add spells already added to this level again
                        foreach ($level->getLearnedSpells() as $cs) {
                            if ($cs->getSpellLevel() === $spellLevel) {
                                $spellsToAdd--;
                            }
                        }

                        if ($spellsToAdd < 1) {
                            continue;
                        }

                        while ($spellsToAdd > 0) {
                            $spellsAdded = true;
                            $level->addLearnedSpell((new ClassSpell())->setClass($class)->setSpellLevel($spellLevel));
                            $spellsToAdd--;
                        }
                    }

                    if ($spellsAdded && in_array('spell', $level->getExtraPoint())) {
                        $level->addLearnedSpell((new ClassSpell())->setClass($class)->setSpellLevel($maxSpellLevel - 1));
                    }

                    $form->add(
                        'learnedSpells',
                        CollectionType::class,
                        array(
                            'label'   => 'New Spell' . ($level->getLearnedSpells()->count() > 1 ? 's' : ''),
                            'entry_type'    => AddCharacterSpellType::class,
                            'entry_options' => array(
                                'learned' => $learned,
                                'em'      => $em,
                                'class-definition' => $class,
                                'label' => false
                            )
                        )
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

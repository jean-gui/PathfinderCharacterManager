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
                    $learned = $character->getLearnedSpells();
                    array_walk($learned, function (ClassSpell $s) {
                        return $s->getId();
                    });

                    foreach ($class->getKnownSpellsPerLevel() as $spellLevel => $known) {
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
                            $level->addLearnedSpell((new ClassSpell())->setClass($class)->setSpellLevel($spellLevel));
                            $spellsToAdd--;
                        }
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

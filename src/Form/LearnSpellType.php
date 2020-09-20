<?php

namespace App\Form;

use App\Entity\Characters\Character;
use App\Entity\Rules\ClassDefinition;
use App\Entity\Rules\ClassSpell;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class LevelUpSpellsType
 *
 * @package App\Form
 */
class LearnSpellType extends AbstractType
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
                /** @var Character $character */
                $character   = $event->getData();
                $knownSpells = $character->getLearnedSpells();

                $canLearnClasses = array();

                foreach ($character->getLevelPerClass() as $classId => $classLevel) {
                    /** @var ClassDefinition $class */
                    $class = $classLevel['class'];
                    if ($class->isAbleToLearnNewSpells()) {
                        $canLearnClasses[] = $class;
                    }
                }

                $learnableSpells = $em->getRepository(ClassSpell::class)->findBy(
                    array('class' => $canLearnClasses, 'spellLevel' => array(1,2,3,4,5,6,7,8,9))
                );

                $groupedLearnableSpells = array();
                foreach ($learnableSpells as $classSpell) {
                    if (!in_array($classSpell, $knownSpells, true)) {
                        $group                            = $classSpell->getClass() . ' level ' . $classSpell->getSpellLevel() . ' spells';
                        $groupedLearnableSpells[$group][] = $classSpell;
                    }
                }

                $event->getForm()->add(
                    'spell',
                    EntityType::class,
                    array(
                        'class'   => ClassSpell::class,
                        'mapped'  => false,
                        'choices' => $groupedLearnableSpells
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
            'data_class' => Character::class
        ));
    }
}

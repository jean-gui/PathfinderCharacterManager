<?php

namespace App\Services;


use App\Entity\Characters\Character;
use App\Entity\Characters\PreparedSpell;
use App\Entity\Characters\SpellEffect;
use App\Entity\Rules\ClassDefinition;
use App\Entity\Rules\Spell;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;

/**
 * Class SpellCasting
 *
 * @package App\Services
 */
class SpellCasting
{
    private $em;
    private $publisher;
    private $extraSpells;

    public function __construct(EntityManagerInterface $em, PublisherInterface $publisher, array $extraSpells)
    {
        $this->em = $em;
        $this->publisher = $publisher;
        $this->extraSpells = $extraSpells;
    }

    /**
     * Returns true if $caster can cast $spell with the class $class
     * $caster can cast a spell if $class has to prepare spells and $caster memorized it enough times
     * or if $class doesn't need to prepare spells and $caster knows the spell with $class and can cast spells of this level
     *
     * @param Character       $caster
     * @param Spell           $spell
     * @param ClassDefinition $class Class the spell will be cast as
     * @param int|null        $spellLevel
     *
     * @return bool
     */
    private function canCast(Character $caster, Spell $spell, ClassDefinition $class, int $spellLevel = null): bool
    {
        // The spell needs to be prepared in advance
        if ($class->isPreparationNeeded()) {
            foreach ($caster->getPreparedSpells() as $preparedSpell) {
                if (
                    $preparedSpell->getSpell() === $spell &&
                    $preparedSpell->getClass() === $class &&
                    !$preparedSpell->isAlreadyCast()
                ) {
                    return true;
                }
            }
        } else { // The spell doesn't need to be prepared but needs to be known and still be castable
            $cast = $caster->getNonPreparedCastSpellsCount();

            foreach ($caster->getLearnedSpells() as $classSpell) {
                if (!$spellLevel) {
                    $spellLevel = $classSpell->getSpellLevel();
                }

                $modifier = $caster->getModifierByAbility($class->getCastingAbility());

                if (
                    $classSpell->getSpell() === $spell &&
                    $classSpell->getClass() === $class &&
                    (
                        !$cast ||
                        !array_key_exists($class->getId(), $cast) ||
                        !array_key_exists($spellLevel, $cast[$class->getId()]) ||
                        (
                            $class->getSpellsPerDay()[$spellLevel][$caster->getLevel($class) - 1] >= 0 &&
                            $cast[$class->getId()][$spellLevel] < ($class->getSpellsPerDay()
                            [$spellLevel][$caster->getLevel($class) - 1] + $this->extraSpells[$modifier][$spellLevel])
                        )
                    )
                ) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param Character        $caster
     * @param Spell            $spell
     * @param ClassDefinition  $class Class the spell is cast as
     * @param Character[]|null $targets
     * @param int|null $spellLevel to cast the spell from a higher level slot (only useful for classes that
     *                             don't require preparing spells)
     *
     * @throws Exception
     */
    public function cast(
        Character $caster,
        Spell $spell,
        ClassDefinition $class,
        array $targets = null,
        int $spellLevel = null
    )
    {
        if (!$this->canCast($caster, $spell, $class, $spellLevel)) {
            throw new Exception($caster . ' cannot cast ' . $spell);
        }

        if ($targets) {
            foreach ($targets as $target) {
                $target->addSpellEffect(
                    (new SpellEffect())
                        ->setSpell($spell)
                        ->setCaster($caster)
                        ->setCasterLevel($caster->getLevel($class))
                );
            }
        }

        if ($class->isPreparationNeeded()) {
            $preparedSpell = $caster->getPreparedSpell($spell, $class);
            // Level 0 spells are not lost after use
            if ($preparedSpell->getSpellLevel() > 0) {
                $preparedSpell->setAlreaydCast(true);
            }
        } else {
            $cast = $caster->getNonPreparedCastSpellsCount();
            $classSpell = $caster->getLearnedSpell($spell, $class);
            if (!$spellLevel || $spellLevel < $classSpell->getSpellLevel()) {
                $spellLevel = $classSpell->getSpellLevel();
            }
            if (!$cast ||
                !array_key_exists($class->getId(), $cast) ||
                !array_key_exists($spellLevel, $cast[$class->getId()])
            ) {
                $cast[$class->getId()][$spellLevel] = 1;
            } else {
                $cast[$class->getId()][$spellLevel]++;
            }
            $caster->setNonPreparedCastSpellsCount($cast);
        }

        $this->em->flush();

        if ($targets) {
            $publisher = $this->publisher;
            foreach ($targets as $target) {
                try {
                    $publisher(
                        new Update(
                            'https://pathfinder.troulite.fr/characters/'.$target->getId(),
                            json_encode(['character' => $target->getId(), 'message' => $spell.' cast on '.$target])
                        )
                    );
                } catch (Exception $e) {}
            }
        }
    }

    public function fixPreparedSpells(Character $character)
    {
        $oldSlots = $character->getPreparedSpells();
        /** @var PreparedSpell[] $newSlots */
        $newSlots = [];

        /* First, compute all spell slots from scratch */
        foreach ($character->getLevelPerClass() as $classId => $values) {
            /** @var ClassDefinition $class */
            $class = $values['class'];
            /** @var int $level */
            $characterLevelForClass = $values['level'];

            if (!$class->isPreparationNeeded()) {
                continue;
            }

            foreach ($class->getSpellsPerDay() as $spellLevel => $spellsPerLevel) {
                // $level starts at 0 while $characterLevelForClass starts at 1
                /** @var int $slotCount number of spells of a specific level per day for this character level */
                $slotCount = $spellsPerLevel[$characterLevelForClass - 1];

                // character can't cast spells of this level
                if ($slotCount < 0) {
                    continue;
                }

                /* First, add slots granted by the class */
                for ($i = 0; $i < $slotCount; $i++) {
                    $newSlots[] = new PreparedSpell(
                        $character, null, $class, false, false, $spellLevel
                    );
                }

                /* Then, add extra slots given by high ability */
                $abilityMod       = $character->getModifierByAbility($class->getCastingAbility());
                $extraSpellsCount = $this->extraSpells[$abilityMod][$spellLevel];
                for ($i = 0; $i < $extraSpellsCount; $i++) {
                    $newSlots[] = new PreparedSpell(
                        $character, null, $class, false, false, $spellLevel
                    );
                }

                /* Finally, add slots given by subclasses */
                // try to find subclasses of $class this character picked at any level
                if ($spellLevel > 0) { // level 0 spells don't benefit from extra subclass slot
                    foreach ($character->getLevels() as $l) {
                        if ($l->getClassDefinition() === $class) {
                            foreach ($l->getSubClasses() as $sc) {
                                if ($sc->getExtraSpellSlot()) {
                                    $newSlots[] = new PreparedSpell(
                                        $character, null, $class, false, true, $spellLevel
                                    );

                                    // end both loops, meaning we only add 1 unique slot for all subclasses (I think
                                    // that's how rules work for all subclasses (subdomains for example))
                                    break 2;
                                }
                            }
                        }
                    }
                }
            }
        }

        $listsAreIdentical = true;

        // One list is bigger than the other, so they can't be identical
        if (count($newSlots) !== $oldSlots->count()) {
            $listsAreIdentical = false;
        }

        /* For each old slot, try to find a corresponding new one and assign the correct spell to it */
        foreach ($oldSlots as $oldSlot) {
            $found = false;
            foreach ($newSlots as $key => $newSlot) {
                if (
                    !$newSlot->getSpell() &&
                    $oldSlot->getLevel() === $newSlot->getLevel() &&
                    $oldSlot->getClass() === $newSlot->getClass() &&
                    $oldSlot->isSubclassSlot() === $newSlot->isSubclassSlot()
                ) {
                    $newSlot->setSpell($oldSlot->getSpell());
                    $newSlot->setAlreaydCast($oldSlot->isAlreadyCast());
                    $found = true;

                    break;
                }
            }

            // we couldn't find a match in the new list, so lists aren't identical
            if (!$found) {
                $listsAreIdentical = false;
            }
        }

        // Replace character's slots with new computed list if differences were found (ideally we should just add/remove
        // slots that differ, but that's more complicated to order properly
        if (!$listsAreIdentical) {
            $character->getPreparedSpells()->clear();
            foreach ($newSlots as $slot) {
                $character->addPreparedSpell($slot);
            }
        }
    }
} 
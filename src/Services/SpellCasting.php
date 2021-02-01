<?php

namespace App\Services;


use App\Entity\Characters\Character;
use App\Entity\Characters\SpellEffect;
use App\Entity\Rules\ClassDefinition;
use App\Entity\Rules\Spell;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
    private function canCast(Character $caster, Spell $spell, ClassDefinition $class, int $spellLevel = null)
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

        $publisher = $this->publisher;
        foreach ($targets as $target) {
            $publisher(
                new Update(
                    'https://pathfinder.troulite.fr/characters/' . $target->getId(),
                    json_encode(['character' => $target->getId(), 'message' => $spell . ' cast on ' . $target])
                )
            );
        }
    }
} 
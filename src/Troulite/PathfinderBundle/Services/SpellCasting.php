<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 02/08/14
 * Time: 15:40
 */

namespace Troulite\PathfinderBundle\Services;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Troulite\PathfinderBundle\Entity\Character;
use Troulite\PathfinderBundle\Entity\ClassDefinition;
use Troulite\PathfinderBundle\Entity\Spell;
use Troulite\PathfinderBundle\Entity\SpellEffect;

/**
 * Class SpellCasting
 *
 * @package Troulite\PathfinderBundle\Services
 */
class SpellCasting
{
    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Returns true if $caster can cast $spell with the class $class
     * $caster can cast a spell if $class has to prepare spells and $caster memorized it enough times
     * or if $class doesn't need to prepare spells and $caster knows the spell with $class and can cast spells of this level
     *
     * @param Character $caster
     * @param Spell $spell
     * @param ClassDefinition $class Class the spell will be cast as
     *
     * @return bool
     *
     * @todo take into account spell per day bonuses for non prepared spells
     */
    private function canCast(Character $caster, Spell $spell, ClassDefinition $class)
    {
        // The spell needs to be prepared in advance
        if ($class->isPreparationNeeded()) {
            foreach ($caster->getPreparedSpells() as $preparedSpell) {
                if (
                    $preparedSpell->getSpell() === $spell &&
                    $preparedSpell->getClass() === $class &&
                    $preparedSpell->getCount() > $preparedSpell->getCastCount()) {
                    return true;
                }
            }
        } else { // The spell doesn't need to be prepared but needs to be known and still be castable
            $cast = $caster->getNonPreparedCastSpellsCount();
            $castPerDay = 0;
            foreach ($caster->getLearnedSpells() as $classSpell) {
                if (
                    $classSpell->getSpell() === $spell &&
                    $classSpell->getClass() === $class &&
                    (
                        !$cast ||
                        !array_key_exists($class->getId(), $cast) ||
                        !array_key_exists($classSpell->getSpellLevel(), $cast[$class->getId()]) ||
                        $cast[$class->getId()][$classSpell->getSpellLevel()] < $class->getSpellsPerDay()[$classSpell->getSpellLevel()][$caster->getLevel($class) - 1]
                    )
                ) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param Character $caster
     * @param Character[]|null $targets
     * @param Spell $spell
     * @param ClassDefinition $class Class the spell is cast as
     *
     * @throws \Exception
     */
    public function cast(Character $caster, Spell $spell, ClassDefinition $class, $targets = null)
    {
        if (!$this->canCast($caster, $spell, $class)) {
            throw new NotFoundHttpException($caster . ' cannot cast ' . $spell);
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
            $preparedSpell->setCastCount($preparedSpell->getCastCount() + 1);
        } else {
            $cast = $caster->getNonPreparedCastSpellsCount();
            $classSpell = $caster->getLearnedSpell($spell, $class);
            if (!$cast || !array_key_exists($class->getId(), $cast) || !array_key_exists($classSpell->getSpellLevel(), $cast[$class->getId()])) {
                $cast[$class->getId()][$classSpell->getSpellLevel()] = 1;
            } else {
                $cast[$class->getId()][$classSpell->getSpellLevel()]++;
            }
            $caster->setNonPreparedCastSpellsCount($cast);
        }

        $this->em->flush();
    }
} 
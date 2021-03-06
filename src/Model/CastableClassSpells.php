<?php

namespace App\Model;

use App\Entity\Rules\ClassDefinition;
use App\Entity\Rules\Spell;

/**
 * Class CastableClassSpells
 *
 * @package App\Model
 */
class CastableClassSpells
{
    /**
     * @var ClassDefinition
     */
    protected $class;

    /**
     * @var CastableLevelSpells[]
     */
    protected $spellsByLevel;

    /**
     *
     */
    public function __construct()
    {
        $this->spellsByLevel = array();
    }

    /**
     * @return ClassDefinition
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param ClassDefinition $class
     *
     * @return $this
     */
    public function setClass(ClassDefinition $class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return CastableLevelSpells[]
     */
    public function getSpellsByLevel()
    {
        return $this->spellsByLevel;
    }

    /**
     * @param CastableLevelSpells[] $spellsByLevel
     *
     * @return $this
     */
    public function setSpellsByLevel(array $spellsByLevel)
    {
        $this->spellsByLevel = $spellsByLevel;

        return $this;
    }

    /**
     * @param Spell $spell
     * @param int   $level
     *
     * @return $this
     */
    public function addSpellToLevel(Spell $spell, int $level)
    {
        if (!array_key_exists($level, $this->spellsByLevel)) {
            $this->spellsByLevel[$level] = new CastableLevelSpells();
            $this->spellsByLevel[$level]->setLevel($level);
        }
        $this->spellsByLevel[$level]->addSpell($spell);

        return $this;
    }
}

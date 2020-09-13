<?php

namespace App\Model;

use App\Entity\Spell;

/**
 * Class CastableLevelSpells
 *
 * @package App\Model
 */
class CastableLevelSpells {
    /**
     * @var int
     */
    private $level;

    /**
     * @var Spell[]
     */
    private $spells;

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     *
     * @return $this
     */
    public function setLevel(int $level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return Spell[]
     */
    public function getSpells()
    {
        return $this->spells;
    }

    /**
     * @param Spell[] $spells
     *
     * @return $this
     */
    public function setSpells(array $spells)
    {
        $this->spells = $spells;

        return $this;
    }

    /**
     * @param Spell $spell
     *
     * @return $this
     */
    public function addSpell(Spell $spell)
    {
        $this->spells[] = $spell;

        return $this;
    }

}
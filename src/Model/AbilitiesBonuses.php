<?php

namespace App\Model;


/**
 * Class AbilitiesBonuses
 *
 * @package App\Model
 */
class AbilitiesBonuses
{
    /**
     * @var Bonuses
     */
    public $strength;

    /**
     * @var Bonuses
     */
    public $dexterity;

    /**
     * @var Bonuses
     */
    public $constitution;

    /**
     * @var Bonuses
     */
    public $intelligence;

    /**
     * @var Bonuses
     */
    public $wisdom;

    /**
     * @var Bonuses
     */
    public $charisma;

    /**
     * @var Bonuses
     */
    public $maxDexterityBonuses;

    /**
     * Create a new AbilitiesBonuses instance
     */
    public function __construct()
    {
        $this->strength = new Bonuses();
        $this->dexterity = new Bonuses();
        $this->constitution = new Bonuses();
        $this->intelligence = new Bonuses();
        $this->wisdom = new Bonuses();
        $this->charisma = new Bonuses();
        $this->maxDexterityBonuses = new Bonuses();
    }
} 
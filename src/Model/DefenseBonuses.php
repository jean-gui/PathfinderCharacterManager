<?php

namespace App\Model;


/**
 * Class DefenseBonuses
 *
 * @package App\Model
 */
class DefenseBonuses
{
    /**
     * @var Bonuses
     */
    public $fortitude;

    /**
     * @var Bonuses
     */
    public $reflexes;

    /**
     * @var Bonuses
     */
    public $will;

    /**
     * @var Bonuses
     */
    public $ac;

    /**
     * @var Bonuses
     */
    public $spellResitance;

    /**
     * Create a new DefenseBonuses instance
     */
    public function __construct()
    {
        $this->ac = new Bonuses();
        $this->reflexes = new Bonuses();
        $this->fortitude = new Bonuses();
        $this->will = new Bonuses();
        $this->spellResitance = new Bonuses();
    }
} 
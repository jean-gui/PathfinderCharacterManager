<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 18/07/14
 * Time: 22:45
 */

namespace Troulite\PathfinderBundle\Model;


/**
 * Class AbilitiesBonuses
 *
 * @package Troulite\PathfinderBundle\Model
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
    }
} 
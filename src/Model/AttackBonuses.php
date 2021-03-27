<?php

namespace App\Model;

/**
 * Class AttackBonuses
 *
 * @package App\Model
 */
class AttackBonuses
{
    /**
     * @var Bonuses
     */
    public $mainAttackRolls;

    /**
     * @var Bonuses
     */
    public $offhandAttackRolls;

    /**
     * @var Bonuses
     */
    public $mainDamage;

    /**
     * @var Bonuses
     */
    public $offhandDamage;

    /**
     * @var Bonuses
     */
    public $rangedAttackRolls;

    /**
     * @var Bonuses
     */
    public $mainAttacks;

    /**
     * @var Bonuses
     */
    public $offhandAttacks;

    /**
     * @var Bonuses
     */
    public $meleeAttackRolls;

    /**
     * @var Bonuses
     */
    public $rangedAttacks;

    /**
     * @var Bonuses
     */
    public $meleeAttacks;

    /**
     * @var Bonuses
     */
    public $rangedDamage;

    /**
     * @var Bonuses
     */
    public $meleeDamage;

    /**
     * @var Bonuses
     */
    public $initiative;

    /**
     * @var Bonuses
     */
    public $cmb;

    /**
     * @var Bonuses
     */
    public $cmd;

    /**
     * Create a new AttackBonuses instance
     */
    public function __construct()
    {
        $this->mainAttacks     = new Bonuses();
        $this->mainAttackRolls = new Bonuses();
        $this->mainDamage      = new Bonuses();

        $this->offhandAttacks     = new Bonuses();
        $this->offhandAttackRolls = new Bonuses();
        $this->offhandDamage = new Bonuses();

        $this->meleeAttackRolls = new Bonuses();
        $this->meleeAttacks = new Bonuses();
        $this->meleeDamage = new Bonuses();

        $this->rangedAttackRolls = new Bonuses();
        $this->rangedAttacks = new Bonuses();
        $this->rangedDamage = new Bonuses();

        $this->initiative = new Bonuses();
        $this->cmb = new Bonuses();
        $this->cmd = new Bonuses();
    }
}

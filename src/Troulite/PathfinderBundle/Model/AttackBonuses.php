<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 18/07/14
 * Time: 00:08
 */

namespace Troulite\PathfinderBundle\Model;


/**
 * Class AttackBonuses
 *
 * @package Troulite\PathfinderBundle\Model
 */
class AttackBonuses
{
    /**
     * @var Bonuses
     */
    public $rangedAttackRolls = 0;

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
<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 18/07/14
 * Time: 00:08
 */
/*
 * Copyright 2015 Jean-Guilhem Rouel
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
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
    public $rangedAttackRolls = 0;

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
        $this->mainDamage = new Bonuses();

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
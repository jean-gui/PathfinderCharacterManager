<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 18/07/14
 * Time: 22:45
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
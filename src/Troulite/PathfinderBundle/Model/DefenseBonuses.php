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
 * Class DefenseBonuses
 *
 * @package Troulite\PathfinderBundle\Model
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
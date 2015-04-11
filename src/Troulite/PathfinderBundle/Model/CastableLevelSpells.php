<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 06/03/15
 * Time: 14:08
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

use Troulite\PathfinderBundle\Entity\Spell;

/**
 * Class CastableLevelSpells
 *
 * @package Troulite\PathfinderBundle\Model
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
    public function setLevel($level)
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
    public function setSpells($spells)
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
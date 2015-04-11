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


use Troulite\PathfinderBundle\Entity\ClassDefinition;
use Troulite\PathfinderBundle\Entity\Spell;

/**
 * Class CastableClassSpells
 *
 * @package Troulite\PathfinderBundle\Model
 */
class CastableClassSpells {
    /**
     * @var ClassDefinition
     */
    private $class;

    /**
     * @var CastableLevelSpells[]
     */
    private $spellsByLevel;

    /**
     *
     */
    public function __construct()
    {
        $this->spellsByLevel = array();
    }

    /**
     * @return ClassDefinition
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param ClassDefinition $class
     *
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return CastableLevelSpells[]
     */
    public function getSpellsByLevel()
    {
        return $this->spellsByLevel;
    }

    /**
     * @param CastableLevelSpells[] $spellsByLevel
     *
     * @return $this
     */
    public function setSpellsByLevel($spellsByLevel)
    {
        $this->spellsByLevel = $spellsByLevel;

        return $this;
    }

    /**
     * @param Spell $spell
     * @param int $level
     *
     * @return $this
     */
    public function addSpellToLevel(Spell $spell, $level)
    {
        if (!array_key_exists($level, $this->spellsByLevel)) {
            $this->spellsByLevel[$level] = new CastableLevelSpells();
            $this->spellsByLevel[$level]->setLevel($level);
        }
        $this->spellsByLevel[$level]->addSpell($spell);

        return $this;
    }
}
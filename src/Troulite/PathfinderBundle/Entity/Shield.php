<?php

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

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Shield
 *
 * @ORM\Table()
 * @ORM\Entity
 *
 * @todo Really implement that class
 */
class Shield extends Item
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $ac;

    /**
     * @var int
     *
     * @ORM\Column(name="maxDexterityBonus", type="integer", nullable=false)
     */
    private $maximumDexterityBonus = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="armorCheckPenalty", type="integer", nullable=false)
     */
    private $armorCheckPenalty = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="arcaneSpellFailure", type="integer", nullable=false)
     */
    private $arcaneSpellFailure = 0;

    /**
     * @param int $ac
     *
     * @return $this
     */
    public function setAc($ac)
    {
        $this->ac = $ac;

        return $this;
    }

    /**
     * @return int
     */
    public function getAc()
    {
        return $this->ac;
    }

    /**
     * @param int $arcaneSpellFailure
     *
     * @return $this
     */
    public function setArcaneSpellFailure($arcaneSpellFailure)
    {
        $this->arcaneSpellFailure = $arcaneSpellFailure;

        return $this;
    }

    /**
     * @return int
     */
    public function getArcaneSpellFailure()
    {
        return $this->arcaneSpellFailure;
    }

    /**
     * @param int $armorCheckPenalty
     *
     * @return $this
     */
    public function setArmorCheckPenalty($armorCheckPenalty)
    {
        $this->armorCheckPenalty = $armorCheckPenalty;

        return $this;
    }

    /**
     * @return int
     */
    public function getArmorCheckPenalty()
    {
        return $this->armorCheckPenalty;
    }

    /**
     * @param int $maximumDexterityBonus
     *
     * @return $this
     */
    public function setMaximumDexterityBonus($maximumDexterityBonus)
    {
        $this->maximumDexterityBonus = $maximumDexterityBonus;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaximumDexterityBonus()
    {
        return $this->maximumDexterityBonus;
    }
}

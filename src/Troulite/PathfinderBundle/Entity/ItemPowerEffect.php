<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 29/06/14
 * Time: 18:54
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

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Troulite\PathfinderBundle\Entity\Traits\Power;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * ItemPowerEffect
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ItemPowerEffect
{
    use Power;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Target character of this power effect
     *
     * @var Character
     *
     * @ORM\ManyToOne(targetEntity="Character", inversedBy="itemPowerEffects")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    protected $character;

    /**
     * Power that triggered this power effect
     *
     * @var Character|null Target of the power or null if the corresponding power
     *
     * @ORM\ManyToOne(targetEntity="ItemPower")
     * @ORM\JoinColumn(name="power_id", referencedColumnName="id", nullable=false)
     */
    protected $power;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $active = false;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getPower()->getName();
    }

    /**
     * @param ItemPower $power
     *
     * @return $this
     */
    public function setPower(ItemPower $power)
    {
        $this->power = $power;

        return $this;
    }

    /**
     * @return ItemPower
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * @param Character $character
     *
     * @return $this
     */
    public function setCharacter(Character $character = null)
    {
        $this->character = $character;

        return $this;
    }

    /**
     * @return Character
     */
    public function getCharacter()
    {
        return $this->character;
    }


    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return CharacterFeat
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }
}

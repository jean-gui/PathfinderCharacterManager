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

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Troulite\PathfinderBundle\Entity\Traits\Describable;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Item
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *     "weapon" = "Weapon", "armor" = "Armor", "shield" = "Shield", "shoulders" = "Shoulders", "ring" = "Ring",
 *     "neck" = "Neck", "belt" = "Belt", "wrists" = "Wrists", "feet" = "Feet", "hands" = "Hands", "eyes" = "Eyes",
 *     "head" = "Head", "headband" = "Headband", "body" = "Body", "chest" = "Chest", "item" = "Item"
 * })
 */
class Item
{
    use Describable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Gedmo\Translatable()
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="cost", type="integer")
     */
    private $cost;

    /**
     * @var double
     *
     * @ORM\Column(name="weight", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $weight;

    /**
     * @var Collection|ItemPower[]
     *
     * @ORM\ManyToMany(targetEntity="ItemPower", cascade={"all"})
     * @ORM\JoinTable(name="ItemPowers",
     *     joinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="power_id", referencedColumnName="id")}
     * )
     */
    private $powers;

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
     * Set name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set cost
     *
     * @param integer $cost
     *
     * @return $this
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return integer
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set weight
     *
     * @param double $weight
     *
     * @return $this
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return double
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Add power
     *
     * @param ItemPower $power
     *
     * @return $this
     */
    public function addPower(ItemPower $power)
    {
        $this->powers[] = $power;

        return $this;
    }

    /**
     * Remove power
     *
     * @param ItemPower $power
     */
    public function removePower(ItemPower $power)
    {
        $this->powers->removeElement($power);
    }

    /**
     * Get powers
     *
     * @return Collection|ItemPower[]
     */
    public function getPowers()
    {
        return $this->powers;
    }
}

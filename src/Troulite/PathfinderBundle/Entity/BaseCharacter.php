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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * BaseCharacter
 *
 * @ORM\MappedSuperclass()
 */
class BaseCharacter
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="characters")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Race")
     * @ORM\JoinColumn(name="race_id", referencedColumnName="id")
     * @ORM\Cache()
     * @Assert\NotBlank()
     */
    private $race;

    /**
     * @var ClassDefinition
     *
     * @ORM\ManyToOne(targetEntity="ClassDefinition")
     * @ORM\JoinColumn(name="favoredClass", referencedColumnName="id", nullable=false)
     * @ORM\Cache()
     */
    private $favoredClass;

    /**
     * @var Abilities
     *
     * @ORM\OneToOne(targetEntity="Abilities", cascade={"all"})
     * @ORM\JoinColumn(name="abilities_id", referencedColumnName="id")
     */
    private $abilities;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $lostHP = 0;

    /**
     * @var CharacterEquipment
     *
     * @ORM\OneToOne(targetEntity="CharacterEquipment", inversedBy="character", cascade={"all"})
     * @ORM\JoinColumn(name="equipment_id", referencedColumnName="id")
     */
    private $equipment;

    /**
     * @var Party
     *
     * @ORM\ManyToOne(targetEntity="Party", inversedBy="characters")
     * @ORM\JoinColumn(name="party_id", referencedColumnName="id")
     */
    private $party;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $generalNotes;
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $powerNotes;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $inventoryNotes;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $spellNotes;

    /**
     * @var Collection|ClassSpell[]
     *
     * @ORM\ManyToMany(targetEntity="ClassSpell")
     * @ORM\JoinTable(name="character_spells",
     *      joinColumns={@ORM\JoinColumn(name="character_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="classspell_id", referencedColumnName="id")}
     *      )
     */
    private $extraSpells;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->abilities = new Abilities();
        $this->equipment = new CharacterEquipment();
        $this->extraSpells = new ArrayCollection();
    }

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
        return $this->getName();
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return $this
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get currentHP
     *
     * @return string
     */
    public function getLostHP()
    {
        return $this->lostHP;
    }

    /**
     * Set lostHP
     *
     * @param string $lostHP
     *
     * @return $this
     */
    public function setLostHP($lostHP)
    {
        $this->lostHP = $lostHP;

        return $this;
    }

    /**
     * Get favoredClass
     *
     * @return ClassDefinition
     */
    public function getFavoredClass()
    {
        return $this->favoredClass;
    }

    /**
     * Set favoredClass
     *
     * @param ClassDefinition $favoredClass
     *
     * @return $this
     */
    public function setFavoredClass(ClassDefinition $favoredClass)
    {
        $this->favoredClass = $favoredClass;

        return $this;
    }

    /**
     * Get race
     *
     * @return Race
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * Set race
     *
     * @param Race $race
     *
     * @return $this
     */
    public function setRace(Race $race = null)
    {
        $this->race = $race;

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
     * Get party
     *
     * @return Party
     */
    public function getParty()
    {
        return $this->party;
    }

    /**
     * Set party
     *
     * @param Party $party
     *
     * @return $this
     */
    public function setParty(Party $party = null)
    {
        $this->party = $party;

        return $this;
    }

    /**
     * Set abilities
     *
     * @param Abilities $abilities
     *
     * @return $this
     */
    public function setAbilities(Abilities $abilities = null)
    {
        $this->abilities = $abilities;

        return $this;
    }

    /**
     * Get abilities
     *
     * @return Abilities
     */
    public function getAbilities()
    {
        return $this->abilities;
    }

    /**
     * Set equipment
     *
     * @param CharacterEquipment $equipment
     *
     * @return $this
     */
    public function setEquipment(CharacterEquipment $equipment = null)
    {
        $this->equipment = $equipment;

        return $this;
    }

    /**
     * Get equipment
     *
     * @return CharacterEquipment
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * @return string
     */
    public function getGeneralNotes()
    {
        return $this->generalNotes;
    }

    /**
     * @param string $generalNotes
     *
     * @return $this
     */
    public function setGeneralNotes($generalNotes)
    {
        $this->generalNotes = $generalNotes;

        return $this;
    }

    /**
     * @return string
     */
    public function getPowerNotes()
    {
        return $this->powerNotes;
    }

    /**
     * @param string $powerNotes
     *
     * @return $this
     */
    public function setPowerNotes($powerNotes)
    {
        $this->powerNotes = $powerNotes;

        return $this;
    }

    /**
     * @return string
     */
    public function getInventoryNotes()
    {
        return $this->inventoryNotes;
    }

    /**
     * @param string $inventoryNotes
     *
     * @return $this
     */
    public function setInventoryNotes($inventoryNotes)
    {
        $this->inventoryNotes = $inventoryNotes;

        return $this;
    }

    /**
     * @return string
     */
    public function getSpellNotes()
    {
        return $this->spellNotes;
    }

    /**
     * @param string $spellNotes
     *
     * @return $this
     */
    public function setSpellNotes($spellNotes)
    {
        $this->spellNotes = $spellNotes;

        return $this;
    }

    /**
     * Add extra spell
     *
     * @param ClassSpell $extraSpell
     *
     * @return $this
     */
    public function addExtraSpell(ClassSpell $extraSpell)
    {
        $this->extraSpells[] = $extraSpell;

        return $this;
    }

    /**
     * Remove extra spell
     *
     * @param ClassSpell $extraSpell
     */
    public function removeExtraSpell(ClassSpell $extraSpell)
    {
        $this->extraSpells->removeElement($extraSpell);
    }

    /**
     * Get extra spells
     *
     * @return Collection|ClassSpell[]
     */
    public function getExtraSpells()
    {
        return $this->extraSpells;
    }

    /**
     * @param Collection|ClassSpell[] $extraSpells
     *
     * @return $this
     */
    public function setExtraSpells(Collection $extraSpells)
    {
        $this->extraSpells = $extraSpells;

        return $this;
    }
}

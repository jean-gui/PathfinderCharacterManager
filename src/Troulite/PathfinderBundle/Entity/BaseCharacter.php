<?php

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * BaseCharacter
 *
 * @ORM\Table()
 * @ORM\Entity
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
     * @Assert\NotBlank()
     */
    private $race;

    /**
     * @var Collection|Level[]
     *
     * @ORM\OneToMany(targetEntity="Level", mappedBy="character", cascade={"all"})
     */
    private $levels;

    /**
     * @var ClassDefinition
     *
     * @ORM\ManyToOne(targetEntity="ClassDefinition")
     * @ORM\JoinColumn(name="favoredClass", referencedColumnName="id", nullable=false)
     */
    private $favoredClass;

    /**
     * Determines whether to add an extra skill point or HP when a favored class is chosen when leveling up
     *
     * @var string one of 'skill', 'hp'
     *
     * @ORM\Column(type="string")
     */
    private $extraPoint;

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
     * @var Collection|Feat[]
     *
     * @ORM\OneToMany(targetEntity="CharacterFeat", mappedBy="character", cascade={"all"})
     */
    private $feats;

    /**
     * @var Collection|Feat[]
     *
     * @ORM\ManyToMany(targetEntity="Item")
     * @ORM\JoinTable(name="inventories",
     *      joinColumns={@ORM\JoinColumn(name="character_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id")}
     *      )
     */
    private $inventory;

    /**
     * @var Equipment
     *
     * @ORM\OneToOne(targetEntity="Equipment", cascade={"all"})
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
     * Constructor
     */
    public function __construct()
    {
        $this->levels = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
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
     * Add level
     *
     * @param Level $level
     *
     * @return BaseCharacter
     */
    public function addLevel(Level $level)
    {
        $level->setCharacter($this);
        $this->levels[] = $level;

        return $this;
    }

    /**
     * Remove level
     *
     * @param Level $level
     */
    public function removeLevel(Level $level)
    {
        $level->setCharacter(null);
        $this->levels->removeElement($level);
    }

    /**
     * Get level
     *
     * @return Collection|Level[]
     */
    public function getLevels()
    {
        return $this->levels;
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
     * @return BaseCharacter
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
     * @return BaseCharacter
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
     * @return BaseCharacter
     */
    public function setRace(Race $race = null)
    {
        $this->race = $race;

        return $this;
    }

    /**
     * Add feats
     *
     * @param CharacterFeat $feat
     *
     * @return BaseCharacter
     */
    public function addFeat(CharacterFeat $feat)
    {
        $feat->setCharacter($this);
        $this->feats[] = $feat;

        return $this;
    }

    /**
     * Remove feat
     *
     * @param CharacterFeat $feat
     */
    public function removeFeat(CharacterFeat $feat)
    {
        $this->feats->removeElement($feat);
    }

    /**
     * Get feats
     *
     * @return Collection|CharacterFeat[]
     */
    public function getFeats()
    {
        return $this->feats;
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
     * @return BaseCharacter
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Add inventory
     *
     * @param Item $inventory
     *
     * @return BaseCharacter
     */
    public function addInventory(Item $inventory)
    {
        $this->inventory[] = $inventory;

        return $this;
    }

    /**
     * Remove inventory
     *
     * @param Item $inventory
     */
    public function removeInventory(Item $inventory)
    {
        $this->inventory->removeElement($inventory);
    }

    /**
     * Get inventory
     *
     * @return Collection
     */
    public function getInventory()
    {
        return $this->inventory;
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
     * @return BaseCharacter
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

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
     * @return BaseCharacter
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
     * @return BaseCharacter
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
     * @param Equipment $equipment
     *
     * @return BaseCharacter
     */
    public function setEquipment(Equipment $equipment = null)
    {
        $this->equipment = $equipment;

        return $this;
    }

    /**
     * Get equipment
     *
     * @return Equipment
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * Set extraPoint
     *
     * @param string $extraPoint
     * @return BaseCharacter
     */
    public function setExtraPoint($extraPoint)
    {
        $this->extraPoint = $extraPoint;

        return $this;
    }

    /**
     * Get extraPoint
     *
     * @return string 
     */
    public function getExtraPoint()
    {
        return $this->extraPoint;
    }
}

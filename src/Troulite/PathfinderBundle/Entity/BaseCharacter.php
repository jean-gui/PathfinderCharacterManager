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
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $lostHP = 0;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $strength;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $dexterity;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $constitution;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $intelligence;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $wisdom;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $charisma;

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
     * @var Weapon $leftWeapon
     *
     * @ORM\ManyToOne(targetEntity="Weapon")
     * @ORM\JoinColumn(name="left_weapon_item_id", referencedColumnName="id")
     */
    private $leftWeapon;

    /**
     * @var Weapon $rightWeapon
     *
     * @ORM\ManyToOne(targetEntity="Weapon")
     * @ORM\JoinColumn(name="right_weapon_item_id", referencedColumnName="id")
     */
    private $rightWeapon;

    /**
     * @var Item $body
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="body_item_id", referencedColumnName="id")
     */
    private $body;

    /**
     * @var Item $leftFinger
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="left_finger_item_id", referencedColumnName="id")
     */
    private $leftFinger;

    /**
     * @var Item $rightFinger
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="right_finger_item_id", referencedColumnName="id")
     */
    private $rightFinger;

    /**
     * @var Item $feet
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="feet_item_id", referencedColumnName="id")
     */
    private $feet;

    /**
     * @var Item $neck
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="neck_item_id", referencedColumnName="id")
     */
    private $neck;

    /**
     * @var Item $back
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="back_item_id", referencedColumnName="id")
     */
    private $back;

    /**
     * @var Item $head
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="head_item_id", referencedColumnName="id")
     */
    private $head;

    /**
     * @var Item $belt
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="belt_item_id", referencedColumnName="id")
     */
    private $belt;

    /**
     * @var Item $hands
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="hands_item_id", referencedColumnName="id")
     */
    private $hands;

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
        $this->level = new ArrayCollection();
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
     * Get intelligence
     *
     * @return integer
     */
    public function getIntelligence()
    {
        return $this->intelligence;
    }

    /**
     * Set intelligence
     *
     * @param integer $baseIntelligence
     *
     * @return BaseCharacter
     */
    public function setIntelligence($baseIntelligence)
    {
        $this->intelligence = $baseIntelligence;

        return $this;
    }

    /**
     * Get charisma
     *
     * @return integer
     */
    public function getCharisma()
    {
        return $this->charisma;
    }

    /**
     * Set charisma
     *
     * @param integer $baseCharisma
     *
     * @return BaseCharacter
     */
    public function setCharisma($baseCharisma)
    {
        $this->charisma = $baseCharisma;

        return $this;
    }

    /**
     * Get dexterity
     *
     * @return integer
     */
    public function getDexterity()
    {
        return $this->dexterity;
    }

    /**
     * Set dexterity
     *
     * @param integer $baseDexterity
     *
     * @return BaseCharacter
     */
    public function setDexterity($baseDexterity)
    {
        $this->dexterity = $baseDexterity;

        return $this;
    }

    /**
     * Get constitution
     *
     * @return integer
     */
    public function getConstitution()
    {
        return $this->constitution;
    }

    /**
     * Set constitution
     *
     * @param integer $baseConstitution
     *
     * @return BaseCharacter
     */
    public function setConstitution($baseConstitution)
    {
        $this->constitution = $baseConstitution;

        return $this;
    }

    /**
     * Get wisdom
     *
     * @return integer
     */
    public function getWisdom()
    {
        return $this->wisdom;
    }

    /**
     * Set wisdom
     *
     * @param integer $baseWisdom
     *
     * @return BaseCharacter
     */
    public function setWisdom($baseWisdom)
    {
        $this->wisdom = $baseWisdom;

        return $this;
    }

    /**
     * Get strength
     *
     * @return integer
     */
    public function getStrength()
    {
        return $this->strength;
    }

    /**
     * Set strength
     *
     * @param integer $baseStrength
     *
     * @return BaseCharacter
     */
    public function setStrength($baseStrength)
    {
        $this->strength = $baseStrength;

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
     * Get leftWeapon
     *
     * @return Weapon
     */
    public function getLeftWeapon()
    {
        return $this->leftWeapon;
    }

    /**
     * Set leftWeapon
     *
     * @param Weapon $weapon
     *
     * @return BaseCharacter
     */
    public function setLeftWeapon(Weapon $weapon = null)
    {
        // Unequip right-hand weapon if this weapon is dual-weilded
        if ($weapon && $weapon->isDualWield()) {
            $this->setRightWeapon(null);
        }
        $this->leftWeapon = $weapon;

        return $this;
    }

    /**
     * Get rightWeapon
     *
     * @return Weapon
     */
    public function getRightWeapon()
    {
        return $this->rightWeapon;
    }

    /**
     * Set rightHand
     *
     * @param Weapon $weapon
     *
     * @return BaseCharacter
     */
    public function setRightWeapon(Weapon $weapon = null)
    {
        // Unequip left-hand weapon if this weapon is dual-weilded
        if ($weapon && $weapon->isDualWield()) {
            $this->setLeftWeapon(null);
        }
        $this->rightFinger = $weapon;

        return $this;
    }

    /**
     * Get body
     *
     * @return Item
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set body
     *
     * @param Item $body
     *
     * @return BaseCharacter
     */
    public function setBody(Item $body = null)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get leftFinger
     *
     * @return Item
     */
    public function getLeftFinger()
    {
        return $this->leftFinger;
    }

    /**
     * Set leftFinger
     *
     * @param Item $leftFinger
     *
     * @return BaseCharacter
     */
    public function setLeftFinger(Item $leftFinger = null)
    {
        $this->leftFinger = $leftFinger;

        return $this;
    }

    /**
     * Get rightFinger
     *
     * @return Item
     */
    public function getRightFinger()
    {
        return $this->rightFinger;
    }

    /**
     * Set rightFinger
     *
     * @param Item $rightFinger
     *
     * @return BaseCharacter
     */
    public function setRightFinger(Item $rightFinger = null)
    {
        $this->rightFinger = $rightFinger;

        return $this;
    }

    /**
     * Get feet
     *
     * @return Item
     */
    public function getFeet()
    {
        return $this->feet;
    }

    /**
     * Set feet
     *
     * @param Item $feet
     *
     * @return BaseCharacter
     */
    public function setFeet(Item $feet = null)
    {
        $this->feet = $feet;

        return $this;
    }

    /**
     * Get neck
     *
     * @return Item
     */
    public function getNeck()
    {
        return $this->neck;
    }

    /**
     * Set neck
     *
     * @param Item $neck
     *
     * @return BaseCharacter
     */
    public function setNeck(Item $neck = null)
    {
        $this->neck = $neck;

        return $this;
    }

    /**
     * Get back
     *
     * @return Item
     */
    public function getBack()
    {
        return $this->back;
    }

    /**
     * Set back
     *
     * @param Item $back
     *
     * @return BaseCharacter
     */
    public function setBack(Item $back = null)
    {
        $this->back = $back;

        return $this;
    }

    /**
     * Get head
     *
     * @return Item
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * Set head
     *
     * @param Item $head
     *
     * @return BaseCharacter
     */
    public function setHead(Item $head = null)
    {
        $this->head = $head;

        return $this;
    }

    /**
     * Get belt
     *
     * @return Item
     */
    public function getBelt()
    {
        return $this->belt;
    }

    /**
     * Set belt
     *
     * @param Item $belt
     *
     * @return BaseCharacter
     */
    public function setBelt(Item $belt = null)
    {
        $this->belt = $belt;

        return $this;
    }

    /**
     * Get hands
     *
     * @return Item
     */
    public function getHands()
    {
        return $this->hands;
    }

    /**
     * Set hands
     *
     * @param Item $hands
     *
     * @return BaseCharacter
     */
    public function setHands(Item $hands = null)
    {
        $this->hands = $hands;

        return $this;
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
}

<?php

namespace App\Entity\Characters;

use App\Entity\Items\Armor;
use App\Entity\Items\Belt;
use App\Entity\Items\Body;
use App\Entity\Items\Chest;
use App\Entity\Items\Eyes;
use App\Entity\Items\Feet;
use App\Entity\Items\Hands;
use App\Entity\Items\Head;
use App\Entity\Items\Headband;
use App\Entity\Items\Item;
use App\Entity\Items\Neck;
use App\Entity\Items\Ring;
use App\Entity\Items\Shield;
use App\Entity\Items\Shoulders;
use App\Entity\Items\Weapon;
use App\Entity\Items\Wrists;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CharacterEquipment
 *
 * @package App\Entity
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class CharacterEquipment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Character
     *
     * @ORM\OneToOne(targetEntity=Character::class, mappedBy="equipment")
     */
    protected $character;

    /**
     * @var Weapon $mainWeapon
     *
     * @ORM\ManyToOne(targetEntity=Weapon::class)
     * @ORM\JoinColumn(name="main_weapon_item_id", referencedColumnName="id")
     */
    protected $mainWeapon;

    /**
     * @var Weapon|Shield $rightWeapon
     *
     * @ORM\ManyToOne(targetEntity=Item::class)
     * @ORM\JoinColumn(name="offhand_weapon_item_id", referencedColumnName="id")
     */
    protected $offhandWeapon;

    /**
     * @var Armor $armor
     *
     * @ORM\ManyToOne(targetEntity=Armor::class)
     * @ORM\JoinColumn(name="armor_item_id", referencedColumnName="id")
     */
    protected $armor;

    /**
     * @var Body $body
     *
     * @ORM\ManyToOne(targetEntity=Body::class)
     * @ORM\JoinColumn(name="body_item_id", referencedColumnName="id")
     */
    protected $body;

    /**
     * @var Chest $chest
     *
     * @ORM\ManyToOne(targetEntity=Chest::class)
     * @ORM\JoinColumn(name="chest_item_id", referencedColumnName="id")
     */
    protected $chest;

    /**
     * @var Ring $leftFinger
     *
     * @ORM\ManyToOne(targetEntity=Ring::class)
     * @ORM\JoinColumn(name="left_finger_item_id", referencedColumnName="id")
     */
    protected $leftFinger;

    /**
     * @var Ring $rightFinger
     *
     * @ORM\ManyToOne(targetEntity=Ring::class)
     * @ORM\JoinColumn(name="right_finger_item_id", referencedColumnName="id")
     */
    protected $rightFinger;

    /**
     * @var Feet $feet
     *
     * @ORM\ManyToOne(targetEntity=Feet::class)
     * @ORM\JoinColumn(name="feet_item_id", referencedColumnName="id")
     */
    protected $feet;

    /**
     * @var Neck $neck
     *
     * @ORM\ManyToOne(targetEntity=Neck::class)
     * @ORM\JoinColumn(name="neck_item_id", referencedColumnName="id")
     */
    protected $neck;

    /**
     * @var Shoulders $shoulders
     *
     * @ORM\ManyToOne(targetEntity=Shoulders::class)
     * @ORM\JoinColumn(name="back_item_id", referencedColumnName="id")
     */
    protected $shoulders;

    /**
     * @var Eyes $eyes
     *
     * @ORM\ManyToOne(targetEntity=Eyes::class)
     * @ORM\JoinColumn(name="eyes_item_id", referencedColumnName="id")
     */
    protected $eyes;

    /**
     * @var Head $head
     *
     * @ORM\ManyToOne(targetEntity=Head::class)
     * @ORM\JoinColumn(name="head_item_id", referencedColumnName="id")
     */
    protected $head;

    /**
     * @var Headband $headband
     *
     * @ORM\ManyToOne(targetEntity=Headband::class)
     * @ORM\JoinColumn(name="headband_item_id", referencedColumnName="id")
     */
    protected $headband;

    /**
     * @var Belt $belt
     *
     * @ORM\ManyToOne(targetEntity=Belt::class)
     * @ORM\JoinColumn(name="belt_item_id", referencedColumnName="id")
     */
    protected $belt;

    /**
     * @var Hands $hands
     *
     * @ORM\ManyToOne(targetEntity=Hands::class)
     * @ORM\JoinColumn(name="hands_item_id", referencedColumnName="id")
     */
    protected $hands;

    /**
     * @var Wrists $wrists
     *
     * @ORM\ManyToOne(targetEntity=Wrists::class)
     * @ORM\JoinColumn(name="wrists_item_id", referencedColumnName="id")
     */
    protected $wrists;

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
     * @return Character
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * @param Character $character
     *
     * @return $this
     */
    public function setCharacter(Character $character)
    {
        $this->character = $character;

        return $this;
    }

    /**
     * Get leftWeapon
     *
     * @return Weapon
     */
    public function getMainWeapon()
    {
        return $this->mainWeapon;
    }

    /**
     * Set mainWeapon
     *
     * @param Weapon|null $weapon
     *
     * @return CharacterEquipment
     */
    public function setMainWeapon(Weapon $weapon = null)
    {
        // Unequip right-hand weapon if this weapon is dual-weilded
        if ($weapon instanceof Weapon && $weapon->isTwoHanded()) {
            $this->setOffhandWeapon();
        }
        $this->character->addInventory($this->getMainWeapon());
        $this->mainWeapon = $weapon;

        return $this;
    }

    /**
     * Get rightWeapon
     *
     * @return Weapon|Shield
     */
    public function getOffhandWeapon()
    {
        return $this->offhandWeapon;
    }

    /**
     * Set offhandHand
     *
     * @param Item|null $weapon
     *
     * @return CharacterEquipment
     */
    public function setOffhandWeapon(Item $weapon = null)
    {
        // If weapon is two-handed then equip in main hand instead
        if ($weapon instanceof Weapon && $weapon->isTwoHanded()) {
            $this->setMainWeapon($weapon);
            return $this;
        }
        $this->character->addInventory($this->getOffhandWeapon());
        $this->offhandWeapon = $weapon;

        return $this;
    }

    /**
     * Get armor
     *
     * @return Armor
     */
    public function getArmor()
    {
        return $this->armor;
    }

    /**
     * Set armor
     *
     * @param Armor|null $armor
     *
     * @return CharacterEquipment
     */
    public function setArmor(Armor $armor = null)
    {
        $this->character->addInventory($this->getArmor());
        $this->armor = $armor;

        return $this;
    }

    /**
     * Get leftFinger
     *
     * @return Ring
     */
    public function getLeftFinger()
    {
        return $this->leftFinger;
    }

    /**
     * Set leftFinger
     *
     * @param Ring|null $leftFinger
     *
     * @return CharacterEquipment
     */
    public function setLeftFinger(Ring $leftFinger = null)
    {
        $this->character->addInventory($this->getLeftFinger());
        $this->leftFinger = $leftFinger;

        return $this;
    }

    /**
     * Get rightFinger
     *
     * @return Ring
     */
    public function getRightFinger()
    {
        return $this->rightFinger;
    }

    /**
     * Set rightFinger
     *
     * @param Ring|null $rightFinger
     *
     * @return CharacterEquipment
     */
    public function setRightFinger(Ring $rightFinger = null)
    {
        $this->character->addInventory($this->getRightFinger());
        $this->rightFinger = $rightFinger;

        return $this;
    }

    /**
     * Get feet
     *
     * @return Feet
     */
    public function getFeet()
    {
        return $this->feet;
    }

    /**
     * Set feet
     *
     * @param Feet|null $feet
     *
     * @return CharacterEquipment
     */
    public function setFeet(Feet $feet = null)
    {
        $this->character->addInventory($this->getFeet());
        $this->feet = $feet;

        return $this;
    }

    /**
     * Get neck
     *
     * @return Neck
     */
    public function getNeck()
    {
        return $this->neck;
    }

    /**
     * Set neck
     *
     * @param Neck|null $neck
     *
     * @return CharacterEquipment
     */
    public function setNeck(Neck $neck = null)
    {
        $this->character->addInventory($this->getNeck());
        $this->neck = $neck;

        return $this;
    }

    /**
     * Get shoulders
     *
     * @return Shoulders
     */
    public function getShoulders()
    {
        return $this->shoulders;
    }

    /**
     * Set shoulders
     *
     * @param Shoulders|null $shoulders
     *
     * @return CharacterEquipment
     */
    public function setShoulders(Shoulders $shoulders = null)
    {
        $this->character->addInventory($this->getShoulders());
        $this->shoulders = $shoulders;

        return $this;
    }

    /**
     * Get head
     *
     * @return Head
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * Set head
     *
     * @param Head|null $head
     *
     * @return CharacterEquipment
     */
    public function setHead(Head $head = null)
    {
        $this->character->addInventory($this->getHead());
        $this->head = $head;

        return $this;
    }

    /**
     * Get belt
     *
     * @return Belt
     */
    public function getBelt()
    {
        return $this->belt;
    }

    /**
     * Set belt
     *
     * @param Belt|null $belt
     *
     * @return CharacterEquipment
     */
    public function setBelt(Belt $belt = null)
    {
        $this->character->addInventory($this->getBelt());
        $this->belt = $belt;

        return $this;
    }

    /**
     * Get hands
     *
     * @return Hands
     */
    public function getHands()
    {
        return $this->hands;
    }

    /**
     * Set hands
     *
     * @param Hands|null $hands
     *
     * @return CharacterEquipment
     */
    public function setHands(Hands $hands = null)
    {
        $this->character->addInventory($this->getHands());
        $this->hands = $hands;

        return $this;
    }

    /**
     * @return Body
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param Body|null $body
     *
     * @return $this
     */
    public function setBody(Body $body = null)
    {
        $this->character->addInventory($this->getBody());
        $this->body = $body;

        return $this;
    }

    /**
     * @return Chest
     */
    public function getChest()
    {
        return $this->chest;
    }

    /**
     * @param Chest|null $chest
     *
     * @return $this
     */
    public function setChest(Chest $chest = null)
    {
        $this->character->addInventory($this->getChest());
        $this->chest = $chest;

        return $this;
    }

    /**
     * @return Eyes
     */
    public function getEyes()
    {
        return $this->eyes;
    }

    /**
     * @param Eyes|null $eyes
     *
     * @return $this
     */
    public function setEyes(Eyes $eyes = null)
    {
        $this->character->addInventory($this->getEyes());
        $this->eyes = $eyes;

        return $this;
    }

    /**
     * @return Headband
     */
    public function getHeadband()
    {
        return $this->headband;
    }

    /**
     * @param Headband|null $headband
     *
     * @return $this
     */
    public function setHeadband(Headband $headband = null)
    {
        $this->character->addInventory($this->getHeadband());
        $this->headband = $headband;

        return $this;
    }

    /**
     * @return Wrists
     */
    public function getWrists()
    {
        return $this->wrists;
    }

    /**
     * @param Wrists|null $wrists
     *
     * @return $this
     */
    public function setWrists(Wrists $wrists = null)
    {
        $this->character->addInventory($this->getWrists());
        $this->wrists = $wrists;

        return $this;
    }

    /**
     * Returns the number of times an item is equipped (should be 0, 1 or 2 if two identical items are equipped on two
     * different slots like main hand and off hand
     *
     * @param Item $item
     *
     * @return int
     */
    public function isEquipped(Item $item)
    {
        $equipped = 0;
        if ($item === $this->getMainWeapon()) {
            $equipped++;
        }
        if ($item === $this->getOffhandWeapon()) {
            $equipped++;
        }
        if ($item === $this->getRightFinger()) {
            $equipped++;
        }
        if ($item === $this->getLeftFinger()) {
            $equipped++;
        }
        if ($item === $this->getArmor()) {
            $equipped++;
        }
        if ($item === $this->getBelt()) {
            $equipped++;
        }
        if ($item === $this->getBody()) {
            $equipped++;
        }
        if ($item === $this->getChest()) {
            $equipped++;
        }
        if ($item === $this->getEyes()) {
            $equipped++;
        }
        if ($item === $this->getFeet()) {
            $equipped++;
        }
        if ($item === $this->getHands()) {
            $equipped++;
        }
        if ($item === $this->getHead()) {
            $equipped++;
        }
        if ($item === $this->getHeadband()) {
            $equipped++;
        }
        if ($item === $this->getNeck()) {
            $equipped++;
        }
        if ($item === $this->getShoulders()) {
            $equipped++;
        }
        if ($item === $this->getWrists()) {
            $equipped++;
        }

        return $equipped;
    }

    /**
     * @return bool
     */
    public function hasEquippedItems()
    {
        return $this->getMainWeapon() || $this->getOffhandWeapon() ||
        $this->getRightFinger()       || $this->getLeftFinger()    ||
        $this->getArmor()             || $this->getBelt()          ||
        $this->getBody()              || $this->getChest()         ||
        $this->getEyes()              || $this->getFeet()          ||
        $this->getHands()             || $this->getHead()          ||
        $this->getHeadband()          || $this->getNeck()          ||
        $this->getShoulders()         || $this->getWrists();
    }
}

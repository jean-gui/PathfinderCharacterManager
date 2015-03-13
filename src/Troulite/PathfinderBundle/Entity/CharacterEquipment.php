<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 12/07/14
 * Time: 16:28
 */

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CharacterEquipment
 *
 * @package Troulite\PathfinderBundle\Entity
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
    private $id;

    /**
     * @var Weapon $mainWeapon
     *
     * @ORM\ManyToOne(targetEntity="Weapon")
     * @ORM\JoinColumn(name="main_weapon_item_id", referencedColumnName="id")
     */
    private $mainWeapon;

    /**
     * @var Weapon|Shield $rightWeapon
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="offhand_weapon_item_id", referencedColumnName="id")
     */
    private $offhandWeapon;

    /**
     * @var Armor $armor
     *
     * @ORM\ManyToOne(targetEntity="Armor")
     * @ORM\JoinColumn(name="armor_item_id", referencedColumnName="id")
     */
    private $armor;

    /**
     * @var Body $body
     *
     * @ORM\ManyToOne(targetEntity="Body")
     * @ORM\JoinColumn(name="body_item_id", referencedColumnName="id")
     */
    private $body;

    /**
     * @var Chest $chest
     *
     * @ORM\ManyToOne(targetEntity="Chest")
     * @ORM\JoinColumn(name="chest_item_id", referencedColumnName="id")
     */
    private $chest;

    /**
     * @var Ring $leftFinger
     *
     * @ORM\ManyToOne(targetEntity="Ring")
     * @ORM\JoinColumn(name="left_finger_item_id", referencedColumnName="id")
     */
    private $leftFinger;

    /**
     * @var Ring $rightFinger
     *
     * @ORM\ManyToOne(targetEntity="Ring")
     * @ORM\JoinColumn(name="right_finger_item_id", referencedColumnName="id")
     */
    private $rightFinger;

    /**
     * @var Feet $feet
     *
     * @ORM\ManyToOne(targetEntity="Feet")
     * @ORM\JoinColumn(name="feet_item_id", referencedColumnName="id")
     */
    private $feet;

    /**
     * @var Neck $neck
     *
     * @ORM\ManyToOne(targetEntity="Neck")
     * @ORM\JoinColumn(name="neck_item_id", referencedColumnName="id")
     */
    private $neck;

    /**
     * @var Shoulders $shoulders
     *
     * @ORM\ManyToOne(targetEntity="Shoulders")
     * @ORM\JoinColumn(name="back_item_id", referencedColumnName="id")
     */
    private $shoulders;

    /**
     * @var Eyes $eyes
     *
     * @ORM\ManyToOne(targetEntity="Eyes")
     * @ORM\JoinColumn(name="eyes_item_id", referencedColumnName="id")
     */
    private $eyes;

    /**
     * @var Head $head
     *
     * @ORM\ManyToOne(targetEntity="Head")
     * @ORM\JoinColumn(name="head_item_id", referencedColumnName="id")
     */
    private $head;

    /**
     * @var Headband $headband
     *
     * @ORM\ManyToOne(targetEntity="Headband")
     * @ORM\JoinColumn(name="headband_item_id", referencedColumnName="id")
     */
    private $headband;

    /**
     * @var Belt $belt
     *
     * @ORM\ManyToOne(targetEntity="Belt")
     * @ORM\JoinColumn(name="belt_item_id", referencedColumnName="id")
     */
    private $belt;

    /**
     * @var Hands $hands
     *
     * @ORM\ManyToOne(targetEntity="Hands")
     * @ORM\JoinColumn(name="hands_item_id", referencedColumnName="id")
     */
    private $hands;

    /**
     * @var Wrists $wrists
     *
     * @ORM\ManyToOne(targetEntity="Wrists")
     * @ORM\JoinColumn(name="wrists_item_id", referencedColumnName="id")
     */
    private $wrists;

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
     * @param Weapon $weapon
     *
     * @return CharacterEquipment
     */
    public function setMainWeapon(Weapon $weapon = null)
    {
        // Unequip right-hand weapon if this weapon is dual-weilded
        if ($weapon instanceof Weapon && $weapon->isDualWield()) {
            $this->setOffhandWeapon(null);
        }
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
     * @param Weapon|Shield $weapon
     *
     * @return CharacterEquipment
     */
    public function setOffhandWeapon(Item $weapon = null)
    {
        // Unequip left-hand weapon if this weapon is dual-weilded
        if ($weapon instanceof Weapon && $weapon->isDualWield()) {
            $this->setMainWeapon(null);
        }
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
     * @param Armor $armor
     *
     * @return CharacterEquipment
     */
    public function setArmor(Armor $armor = null)
    {
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
     * @param Ring $leftFinger
     *
     * @return CharacterEquipment
     */
    public function setLeftFinger(Ring $leftFinger = null)
    {
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
     * @param Ring $rightFinger
     *
     * @return CharacterEquipment
     */
    public function setRightFinger(Ring $rightFinger = null)
    {
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
     * @param Feet $feet
     *
     * @return CharacterEquipment
     */
    public function setFeet(Feet $feet = null)
    {
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
     * @param Neck $neck
     *
     * @return CharacterEquipment
     */
    public function setNeck(Neck $neck = null)
    {
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
     * @param Shoulders $shoulders
     *
     * @return CharacterEquipment
     */
    public function setShoulders(Shoulders $shoulders = null)
    {
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
     * @param Head $head
     *
     * @return CharacterEquipment
     */
    public function setHead(Head $head = null)
    {
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
     * @param Belt $belt
     *
     * @return CharacterEquipment
     */
    public function setBelt(Belt $belt = null)
    {
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
     * @param Hands $hands
     *
     * @return CharacterEquipment
     */
    public function setHands(Hands $hands = null)
    {
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
     * @param Body $body
     *
     * @return $this
     */
    public function setBody(Body $body = null)
    {
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
     * @param Chest $chest
     *
     * @return $this
     */
    public function setChest(Chest $chest = null)
    {
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
     * @param Eyes $eyes
     *
     * @return $this
     */
    public function setEyes(Eyes $eyes = null)
    {
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
     * @param Headband $headband
     *
     * @return $this
     */
    public function setHeadband(Headband $headband = null)
    {
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
     * @param Wrists $wrists
     *
     * @return $this
     */
    public function setWrists(Wrists $wrists = null)
    {
        $this->wrists = $wrists;

        return $this;
    }

    /**
     * @param Item $item
     *
     * @return bool
     */
    public function isEquipped(Item $item)
    {
        if (
            $item === $this->getMainWeapon()  || $item === $this->getOffhandWeapon() ||
            $item === $this->getRightFinger() || $item === $this->getLeftFinger()    ||
            $item === $this->getArmor()       || $item === $this->getBelt()          ||
            $item === $this->getBody()        || $item === $this->getChest()         ||
            $item === $this->getEyes()        || $item === $this->getFeet()          ||
            $item === $this->getHands()       || $item === $this->getHead()          ||
            $item === $this->getHeadband()    || $item === $this->getNeck()          ||
            $item === $this->getShoulders()   || $item === $this->getWrists()
        ) {
            return true;
        }
        return false;
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

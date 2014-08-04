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
     * @var Armor $body
     *
     * @ORM\ManyToOne(targetEntity="Armor")
     * @ORM\JoinColumn(name="body_item_id", referencedColumnName="id")
     */
    private $body;

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
     * @var Boots $feet
     *
     * @ORM\ManyToOne(targetEntity="Boots")
     * @ORM\JoinColumn(name="feet_item_id", referencedColumnName="id")
     */
    private $feet;

    /**
     * @var Amulet $neck
     *
     * @ORM\ManyToOne(targetEntity="Amulet")
     * @ORM\JoinColumn(name="neck_item_id", referencedColumnName="id")
     */
    private $neck;

    /**
     * @var Cloak $back
     *
     * @ORM\ManyToOne(targetEntity="Cloak")
     * @ORM\JoinColumn(name="back_item_id", referencedColumnName="id")
     */
    private $back;

    /**
     * @var Helm $head
     *
     * @ORM\ManyToOne(targetEntity="Helm")
     * @ORM\JoinColumn(name="head_item_id", referencedColumnName="id")
     */
    private $head;

    /**
     * @var Belt $belt
     *
     * @ORM\ManyToOne(targetEntity="Belt")
     * @ORM\JoinColumn(name="belt_item_id", referencedColumnName="id")
     */
    private $belt;

    /**
     * @var Gloves $hands
     *
     * @ORM\ManyToOne(targetEntity="Gloves")
     * @ORM\JoinColumn(name="hands_item_id", referencedColumnName="id")
     */
    private $hands;

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
     * Get body
     *
     * @return Armor
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set body
     *
     * @param Armor $body
     *
     * @return CharacterEquipment
     */
    public function setBody(Armor $body = null)
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
     * @return CharacterEquipment
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
     * @return CharacterEquipment
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
     * @return CharacterEquipment
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
     * @return CharacterEquipment
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
     * @return CharacterEquipment
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
     * @return CharacterEquipment
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
     * @return CharacterEquipment
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
     * @return CharacterEquipment
     */
    public function setHands(Item $hands = null)
    {
        $this->hands = $hands;

        return $this;
    }
}

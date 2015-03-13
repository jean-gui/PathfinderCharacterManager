<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 06/07/14
 * Time: 16:53
 */

namespace Troulite\PathfinderBundle\Services;

use Troulite\PathfinderBundle\Entity\Armor;
use Troulite\PathfinderBundle\Entity\Belt;
use Troulite\PathfinderBundle\Entity\Body;
use Troulite\PathfinderBundle\Entity\Character;
use Troulite\PathfinderBundle\Entity\Chest;
use Troulite\PathfinderBundle\Entity\Eyes;
use Troulite\PathfinderBundle\Entity\Feet;
use Troulite\PathfinderBundle\Entity\Hands;
use Troulite\PathfinderBundle\Entity\Head;
use Troulite\PathfinderBundle\Entity\Headband;
use Troulite\PathfinderBundle\Entity\Item;
use Troulite\PathfinderBundle\Entity\Neck;
use Troulite\PathfinderBundle\Entity\Ring;
use Troulite\PathfinderBundle\Entity\Shield;
use Troulite\PathfinderBundle\Entity\Shoulders;
use Troulite\PathfinderBundle\Entity\Weapon;
use Troulite\PathfinderBundle\Entity\Wrists;

/**
 * Class CharacterEquipment
 *
 * @package Troulite\PathfinderBundle\Services
 */
class CharacterEquipment
{

    /**
     * @param Character $character
     * @param Item $item
     *
     * @return $this
     * @throws \Exception
     */
    public function equip(Character $character, Item $item)
    {
        $equipment = $character->getEquipment();

        if ($item instanceof Weapon) {
            if ($equipment->getMainWeapon()) {
                $equipment->setOffhandWeapon($item);
            } else {
                $equipment->setMainWeapon($item);
            }
        } elseif ($item instanceof Armor) {
            return $equipment->setArmor($item);
        } elseif ($item instanceof Shield) {
            return $equipment->setOffhandWeapon($item);
        } elseif ($item instanceof Shoulders) {
            return $equipment->setShoulders($item);
        } elseif ($item instanceof Ring) {
            if ($equipment->getRightFinger()) {
                return $equipment->setLeftFinger($item);
            } else {
                return $equipment->setRightFinger();
            }
        } elseif ($item instanceof Neck) {
            return $equipment->setNeck($item);
        } elseif ($item instanceof Belt) {
            return $equipment->setBelt($item);
        } elseif ($item instanceof Wrists) {
            return $equipment->setWrists($item);
        } elseif ($item instanceof Feet) {
            return $equipment->setFeet($item);
        } elseif ($item instanceof Hands) {
            return $equipment->setHands($item);
        } elseif ($item instanceof Eyes) {
            return $equipment->setEyes($item);
        } elseif ($item instanceof Head) {
            return $equipment->setHead($item);
        } elseif ($item instanceof Headband) {
            return $equipment->setHeadband($item);
        } elseif ($item instanceof Body) {
            return $equipment->setBody($item);
        } elseif ($item instanceof Chest) {
            return $equipment->setChest($item);
        } else {
            throw new \Exception('Cannot equip a non-wearable item');
        }

        return $equipment;
    }

    /**
     * @param Character $character
     * @param $slot
     *
     * @return Character
     */
    public function unequipSlot(Character $character, $slot)
    {
        $equipment = $character->getEquipment();
        switch($slot) {
            case 'headband':
                $equipment->setHeadband();
                break;
            case 'head':
                $equipment->setHead();
                break;
            case 'eyes':
                $equipment->setEyes();
                break;
            case 'neck':
                $equipment->setNeck();
                break;
            case 'shoulders':
                $equipment->setShoulders();
                break;
            case 'armor':
                $equipment->setArmor();
                break;
            case 'body':
                $equipment->setBody();
                break;
            case 'chest':
                $equipment->setChest();
                break;
            case 'belt':
                $equipment->setBelt();
                break;
            case 'mainWeapon':
                $equipment->setMainWeapon();
                break;
            case 'offhandWeapon':
                $equipment->setOffhandWeapon();
                break;
            case 'wrists':
                $equipment->setWrists();
                break;
            case 'hands':
                $equipment->setHands();
                break;
            case 'rightFinger':
                $equipment->setRightFinger();
                break;
            case 'leftFinger':
                $equipment->setLeftFinger();
                break;
            case 'feet':
                $equipment->setFeet();
                break;
        }
        return $character;
    }
} 
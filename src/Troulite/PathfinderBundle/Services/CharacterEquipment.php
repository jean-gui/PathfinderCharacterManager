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
            $equipment->setArmor($item);
        } elseif ($item instanceof Shield) {
            $equipment->setOffhandWeapon($item);
        } elseif ($item instanceof Shoulders) {
            $equipment->setShoulders($item);
        } elseif ($item instanceof Ring) {
            if ($equipment->getRightFinger()) {
                $equipment->setLeftFinger($item);
            } else {
                $equipment->setRightFinger();
            }
        } elseif ($item instanceof Neck) {
            $equipment->setNeck($item);
        } elseif ($item instanceof Belt) {
            $equipment->setBelt($item);
        } elseif ($item instanceof Wrists) {
            $equipment->setWrists($item);
        } elseif ($item instanceof Feet) {
            $equipment->setFeet($item);
        } elseif ($item instanceof Hands) {
            $equipment->setHands($item);
        } elseif ($item instanceof Eyes) {
            $equipment->setEyes($item);
        } elseif ($item instanceof Head) {
            $equipment->setHead($item);
        } elseif ($item instanceof Headband) {
            $equipment->setHeadband($item);
        } elseif ($item instanceof Body) {
            $equipment->setBody($item);
        } elseif ($item instanceof Chest) {
            $equipment->setChest($item);
        } else {
            throw new \Exception('Cannot equip a non-wearable item');
        }

        $character->removeInventory($item, 1);

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
        $item = null;
        switch($slot) {
            case 'headband':
                $item = $equipment->getHeadband();
                $equipment->setHeadband();
                break;
            case 'head':
                $item = $equipment->getHead();
                $equipment->setHead();
                break;
            case 'eyes':
                $item = $equipment->getEyes();
                $equipment->setEyes();
                break;
            case 'neck':
                $item = $equipment->getNeck();
                $equipment->setNeck();
                break;
            case 'shoulders':
                $item = $equipment->getShoulders();
                $equipment->setShoulders();
                break;
            case 'armor':
                $item = $equipment->getArmor();
                $equipment->setArmor();
                break;
            case 'body':
                $item = $equipment->getBody();
                $equipment->setBody();
                break;
            case 'chest':
                $item = $equipment->getChest();
                $equipment->setChest();
                break;
            case 'belt':
                $item = $equipment->getBelt();
                $equipment->setBelt();
                break;
            case 'mainWeapon':
                $item = $equipment->getMainWeapon();
                $equipment->setMainWeapon();
                break;
            case 'offhandWeapon':
                $item = $equipment->getOffhandWeapon();
                $equipment->setOffhandWeapon();
                break;
            case 'wrists':
                $item = $equipment->getWrists();
                $equipment->setWrists();
                break;
            case 'hands':
                $item = $equipment->getHands();
                $equipment->setHands();
                break;
            case 'rightFinger':
                $item = $equipment->getRightFinger();
                $equipment->setRightFinger();
                break;
            case 'leftFinger':
                $item = $equipment->getLeftFinger();
                $equipment->setLeftFinger();
                break;
            case 'feet':
                $item = $equipment->getFeet();
                $equipment->setFeet();
                break;
        }

        if ($item) {
            $character->addInventory($item);
        }

        return $character;
    }
} 
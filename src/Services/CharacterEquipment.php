<?php

namespace App\Services;

use App\Entity\Characters\Character;
use App\Entity\Characters\ItemPowerEffect;
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
use Exception;

/**
 * Class CharacterEquipment
 *
 * @package App\Services
 */
class CharacterEquipment
{

    public function equip(Character $character, Item $item): \App\Entity\Characters\CharacterEquipment
    {
        $equipment = $character->getEquipment();

        if ($item instanceof Weapon) {
            // Equip weapon in main hand if free or offhand wielding a shield
            if (!$equipment->getMainWeapon() || $equipment->getOffhandWeapon() instanceof Shield) {
                $equipment->setMainWeapon($item);
            } else {
                $equipment->setOffhandWeapon($item);
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
                $equipment->setRightFinger($item);
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
            throw new Exception('Cannot equip a non-wearable item');
        }

        $character->removeInventory($item, 1);

        foreach ($item->getPowers() as $power) {
            if ((!$power->isPassive() || $power->hasExternalConditions()) && $power->getEffects()) {
                $character->addItemPowerEffect((new ItemPowerEffect())->setPower($power));
            }
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
                $item = $equipment->getShoulders();
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

        foreach ($character->getItemPowerEffects() as $itemPowerEffect) {
            foreach ($item->getPowers() as $power) {
                if ($power === $itemPowerEffect->getPower()) {
                    $character->removeItemPowerEffect($itemPowerEffect);
                }
            }
        }


        return $character;
    }
} 
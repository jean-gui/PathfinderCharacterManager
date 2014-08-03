<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troulite\PathfinderBundle\Entity\EquipmentPower;

/**
 * Class LoadEquipmentPowerData
 *
 * @package Troulite\PathfinderBundle\DataFixtures\ORM
 */
class LoadEquipmentPowerData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $weaponEnhancement1 = new EquipmentPower();
        $weaponEnhancement1
            ->setCost(1)
            ->setEffects(
                array(
                    'melee-attack-roll' => ['type' => 'enhancement', 'value' => '1'],
                    'melee-damage-roll' => ['type' => 'enhancement', 'value' => '1'],
                )
            )
            ->setPassive(true);

        $manager->persist($weaponEnhancement1);
        $manager->flush();

        $this->setReference('melee-weapon-power-enhancement-1', $weaponEnhancement1);

        $weaponEnhancement2 = new EquipmentPower();
        $weaponEnhancement2
            ->setCost(2)
            ->setEffects(
                array(
                    'ranged-attack-roll' => ['type' => 'enhancement', 'value' => '2'],
                    'ranged-damage-roll' => ['type' => 'enhancement', 'value' => '2']
                )
            )
            ->setPassive(true);

        $manager->persist($weaponEnhancement2);
        $manager->flush();

        $this->setReference('ranged-weapon-power-enhancement-2', $weaponEnhancement2);

        $weaponEnhancement5 = new EquipmentPower();
        $weaponEnhancement5
            ->setCost(5)
            ->setEffects(
                array(
                    'melee-attack-roll' => ['type' => 'enhancement', 'value' => '5'],
                    'melee-damage-roll' => ['type' => 'enhancement', 'value' => '5'],
                )
            )
            ->setPassive(true);

        $manager->persist($weaponEnhancement5);
        $manager->flush();
        $this->setReference('melee-weapon-power-enhancement-5', $weaponEnhancement5);

        $armorEnhancement5 = new EquipmentPower();
        $armorEnhancement5
            ->setCost(5)
            ->setEffects(
                array(
                    'ac' => ['type' => 'enhancement', 'value' => '5'],
                )
            )
            ->setPassive(true);

        $manager->persist($armorEnhancement5);
        $manager->flush();

        $this->setReference('armor-power-enhancement-5', $armorEnhancement5);

        $power = new EquipmentPower();
        $power
            ->setCost(2)
            ->setEffects(
                array(
                    'ac' => ['type' => 'enhancement', 'value' => '2'],
                )
            )
            ->setPassive(true);

        $manager->persist($power);
        $manager->flush();

        $this->setReference('shield-power-enhancement-2', $power);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 1;
    }
}
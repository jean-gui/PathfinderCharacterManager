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
        $weaponEnhancement2 = new EquipmentPower();
        $weaponEnhancement2
            ->setCost(2)
            ->setEffects(
                array(
                    'ranged-attack-roll' => ['type' => 'enhancement', 'value' => '2'],
                    'ranged-damage-roll' => ['type' => 'enhancement', 'value' => '2']
                )
            );

        $manager->persist($weaponEnhancement2);
        $manager->flush();

        $this->setReference('weapon-power-enhancement-2', $weaponEnhancement2);

        $armorEnhancement5 = new EquipmentPower();
        $armorEnhancement5
            ->setCost(5)
            ->setEffects(
                array(
                    'ac' => ['type' => 'enhancement', 'value' => '5'],
                )
            );

        $manager->persist($armorEnhancement5);
        $manager->flush();

        $this->setReference('armor-power-enhancement-5', $armorEnhancement5);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 4;
    }
}
<?php

/*
 * Copyright 2015 Jean-Guilhem Rouel
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Troulite\PathfinderBundle\DataFixtures\ORM\Base;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troulite\PathfinderBundle\Entity\EquipmentPower;

/**
 * Class LoadEquipmentPowerData
 *
 * @package Troulite\PathfinderBundle\DataFixtures\ORM\Base
 */
class LoadEquipmentPowerData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $power = new EquipmentPower();
        $power
            ->setCost(1)
            ->setEffects(
                array(
                    'melee-attack-roll' => ['type' => 'enhancement', 'value' => '1'],
                    'melee-damage-roll' => ['type' => 'enhancement', 'value' => '1'],
                )
            )
            ->setPassive(true);

        $manager->persist($power);
        $manager->flush();

        $this->setReference('melee-weapon-power-enhancement-1', $power);

        $power = new EquipmentPower();
        $power
            ->setCost(2)
            ->setEffects(
                array(
                    'ranged-attack-roll' => ['type' => 'enhancement', 'value' => '2'],
                    'ranged-damage-roll' => ['type' => 'enhancement', 'value' => '2']
                )
            )
            ->setPassive(true);

        $manager->persist($power);
        $manager->flush();

        $this->setReference('ranged-weapon-power-enhancement-2', $power);

        $power = new EquipmentPower();
        $power
            ->setCost(5)
            ->setEffects(
                array(
                    'melee-attack-roll' => ['type' => 'enhancement', 'value' => '5'],
                    'melee-damage-roll' => ['type' => 'enhancement', 'value' => '5'],
                )
            )
            ->setPassive(true);

        $manager->persist($power);
        $manager->flush();
        $this->setReference('melee-weapon-power-enhancement-5', $power);

        $power = new EquipmentPower();
        $power
            ->setCost(5)
            ->setEffects(
                array(
                    'ac' => ['type' => 'enhancement', 'value' => 2],
                )
            )
            ->setPassive(true);

        $manager->persist($power);
        $manager->flush();

        $this->setReference('armor-power-enhancement-2', $power);

        $power = new EquipmentPower();
        $power
            ->setCost(5)
            ->setEffects(
                array(
                    'ac' => ['type' => 'enhancement', 'value' => '5'],
                )
            )
            ->setPassive(true);

        $manager->persist($power);
        $manager->flush();

        $this->setReference('armor-power-enhancement-5', $power);

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
        return 9;
    }
}
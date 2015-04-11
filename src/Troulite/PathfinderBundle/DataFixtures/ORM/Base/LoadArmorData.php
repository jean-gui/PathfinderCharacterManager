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
use Troulite\PathfinderBundle\Entity\Armor;

/**
 * Class LoadArmorData
 *
 * @package Troulite\PathfinderBundle\DataFixtures\ORM\Base
 */
class LoadArmorData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $armor = new Armor();
        $armor
            ->setName('Mithral Chain Armor +5')
            ->setAc(4)
            ->setCategory('light')
            ->setCost(26100)
            ->setShortDescription(
                'Covering the torso, this shirt is made up of thousands of interlocking metal rings.'
            )
            ->setWeight(6)
            ->setMaximumDexterityBonus(6)
            ->setArmorCheckPenalty(0)
            ->setArcaneSpellFailure(10)
            ->addPower($this->getReference('armor-power-enhancement-5'));

        $manager->persist($armor);
        $manager->flush();

        $this->setReference('mithral chain mail +5', $armor);

        $armor = new Armor();
        $armor
            ->setName('Mithral Chain Armor')
            ->setAc(4)
            ->setCategory('light')
            ->setCost(17100)
            ->setShortDescription(
                'Covering the torso, this shirt is made up of thousands of interlocking metal rings.'
            )
            ->setWeight(6)
            ->setMaximumDexterityBonus(6)
            ->setArmorCheckPenalty(0)
            ->setArcaneSpellFailure(10);

        $manager->persist($armor);
        $manager->flush();

        $this->setReference('mithral chain mail', $armor);

        $armor = new Armor();
        $armor
            ->setName('Chain Armor +2')
            ->setAc(4)
            ->setCategory('light')
            ->setCost(100)
            ->setShortDescription(
                'Covering the torso, this shirt is made up of thousands of interlocking metal rings.'
            )
            ->setWeight(12.5)
            ->setMaximumDexterityBonus(4)
            ->setArmorCheckPenalty(-1)
            ->setArcaneSpellFailure(20)
            ->addPower($this->getReference('armor-power-enhancement-2'));

        $manager->persist($armor);
        $manager->flush();

        $this->setReference('chain mail +2', $armor);

        $armor = new Armor();
        $armor
            ->setName('Mithral Stoneplate Champion Armor +5')
            ->setAc(9)
            ->setCategory('heavy')
            ->setCost(46800)
            ->setShortDescription(
                'Crafted by dwarven stonesmiths from alchemically strengthened plates of basalt primarily for use by dwarven druids, stoneplate is heavy and unwieldy, but offers incredible protection to its wearer.'
            )
            ->setWeight(12.5)
            ->setMaximumDexterityBonus(3)
            ->setArmorCheckPenalty(-3)
            ->setArcaneSpellFailure(25)
            ->addPower($this->getReference('armor-power-enhancement-5'));

        $manager->persist($armor);
        $manager->flush();

        $this->setReference('mithral stoneplate champion armor +5', $armor);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 13;
    }
}
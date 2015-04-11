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
use Troulite\PathfinderBundle\Entity\Shield;

/**
 * Class LoadShieldData
 *
 * @package Troulite\PathfinderBundle\DataFixtures\ORM\Base
 */
class LoadShieldData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $shield = new Shield();
        $shield
            ->setName('Tower Shield +2')
            ->setAc(4)
            ->setCost(30)
            ->setMaximumDexterityBonus(2)
            ->setArmorCheckPenalty(-9)
            ->setArcaneSpellFailure(50)
            ->setWeight(22.5)
            ->addPower($this->getReference('shield-power-enhancement-2'));

        $manager->persist($shield);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 11;
    }
}
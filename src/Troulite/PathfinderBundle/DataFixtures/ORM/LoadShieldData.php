<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troulite\PathfinderBundle\Entity\Shield;

/**
 * Class LoadShieldData
 *
 * @package Troulite\PathfinderBundle\DataFixtures\ORM
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
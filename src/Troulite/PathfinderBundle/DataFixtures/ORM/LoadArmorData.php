<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troulite\PathfinderBundle\Entity\Armor;

/**
 * Class LoadArmorData
 *
 * @package Troulite\PathfinderBundle\DataFixtures\ORM
 */
class LoadArmorData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $mithralStoneplate5Champion = new Armor();
        $mithralStoneplate5Champion
            ->setName('Mithral Chain Armor +5')
            ->setAc(4)
            ->setCategory('light')
            ->setCost(26100)
            ->setDescription(
                'Covering the torso, this shirt is made up of thousands of interlocking metal rings.'
            )
            ->setWeight(6)
            ->setMaximumDexterityBonus(6)
            ->setArmorCheckPenalty(0)
            ->setArcaneSpellFailure(10)
            ->addPower($this->getReference('armor-power-enhancement-5'));

        $manager->persist($mithralStoneplate5Champion);
        $manager->flush();

        $this->setReference('mithral chain mail +5', $mithralStoneplate5Champion);

        $mithralStoneplate5Champion = new Armor();
        $mithralStoneplate5Champion
            ->setName('Mithral Stoneplate Champion Armor +5')
            ->setAc(9)
            ->setCategory('heavy')
            ->setCost(46800)
            ->setDescription(
                'Crafted by dwarven stonesmiths from alchemically strengthened plates of basalt primarily for use by dwarven druids, stoneplate is heavy and unwieldy, but offers incredible protection to its wearer.'
            )
            ->setWeight(12.5)
            ->setMaximumDexterityBonus(3)
            ->setArmorCheckPenalty(-3)
            ->setArcaneSpellFailure(25)
            ->addPower($this->getReference('armor-power-enhancement-5'));

        $manager->persist($mithralStoneplate5Champion);
        $manager->flush();

        $this->setReference('mithral stoneplate champion armor +5', $mithralStoneplate5Champion);
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
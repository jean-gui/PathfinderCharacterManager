<?php

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
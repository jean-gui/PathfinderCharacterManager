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
        $mithralChainShirt5 = new Armor();
        $mithralChainShirt5
            ->setName('Mithral Chain Armor +5')
            ->setCategory('light')
            ->setCost(26100)
            ->setDescription(
                'Covering the torso, this shirt is made up of thousands of interlocking metal rings.'
            )
            ->setWeight(6)
            ->setMaximumDexterityBonus(6)
            ->setArmorCheckPenalty(0)
            ->setArcaneSpellFailure(10)
            ->setEffect(
                array(
                    'ac' => ['type' => 'armor', 'value' => '9'],
                )
            );

        $manager->persist($mithralChainShirt5);
        $manager->flush();

        $this->setReference('mithral chain mail +5', $mithralChainShirt5);
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
<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troulite\PathfinderBundle\Entity\Race;

class LoadRaceData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $elf = new Race();
        $elf
            ->setName("Elf")
            ->setModifiers(
                array(
                    "dexterity" => 2,
                    "intelligence" => 2,
                    "constitution" => -2
                )
            );

        $manager->persist($elf);
        $manager->flush();

        $this->addReference('elf', $elf);
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
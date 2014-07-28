<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troulite\PathfinderBundle\Entity\ClassSpell;

/**
 * Class LoadClassSpellData
 *
 * @package Troulite\PathfinderBundle\DataFixtures\ORM
 */
class LoadClassSpellData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $classSpell = new ClassSpell();
        $classSpell
            ->setSpell($this->getReference('spell-haste'))
            ->setClass($this->getReference('bard'))
            ->setSpellLevel(3);

        $manager->persist($classSpell);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 3;
    }
}
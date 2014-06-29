<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troulite\PathfinderBundle\Entity\Weapon;

class LoadWeaponData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $longbow = new Weapon();
        $longbow
            ->setName('Longbow')
            ->setCategory('martial')
            ->setCost(75)
            ->setCritical(3)
            ->setDamages('1d8')
            ->setDescription(
                'At almost 5 feet in height, a longbow is made up of one solid piece of carefully curved wood.'
            )
            ->setRange(20)
            ->setDualWield(true)
            ->setWeight(1.5);

        $manager->persist($longbow);
        $manager->flush();
        $this->setReference('longbow', $longbow);

        $longbow2 = new Weapon();
        $longbow2
            ->setName('Longbow +2')
            ->setCategory('martial')
            ->setCost(75)
            ->setCritical(3)
            ->setDamages('1d8')
            ->setDescription(
                'At almost 5 feet in height, a longbow is made up of one solid piece of carefully curved wood.'
            )
            ->setRange(20)
            ->setDualWield(true)
            ->setWeight(1.5)
            ->setEffect(
                array(
                    'attack-roll' => '2',
                    'damage-roll' => '2'
                )
            );

        $manager->persist($longbow2);
        $manager->flush();

        $this->setReference('longbow +2', $longbow2);
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
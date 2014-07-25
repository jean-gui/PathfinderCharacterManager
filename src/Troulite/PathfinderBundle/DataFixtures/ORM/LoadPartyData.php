<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 29/06/14
 * Time: 14:49
 */

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troulite\PathfinderBundle\Entity\Party;

/**
 * Class LoadPartyData
 *
 * @package Troulite\PathfinderBundle\DataFixtures\ORM
 */
class LoadPartyData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $party = new Party();
        $party->setName("Service d'Intervention de Trincavel")
            ->setDungeonMaster($this->getReference('kujar'));
        $manager->persist($party);
        $manager->flush();

        $this->setReference('sit', $party);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 7;
    }
}
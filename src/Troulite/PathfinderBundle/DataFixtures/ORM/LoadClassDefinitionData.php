<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troulite\PathfinderBundle\Entity\ClassDefinition;

class LoadClassDefinitionData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $bab = array();
        $reflexes = array();
        $fortitude = array();
        $will = array();
        for ($i = 0; $i < 20; $i++) {
            $bba[] = $i + 1;
            $reflexes[] = ((int)(($i + 1) / 2)) + 2;
            $fortitude[] = ((int)(($i + 1) / 2)) + 2;
            $will[] = (int)(($i + 1) / 3);
        }
        $spellsPerDay = array(
            1 => array(-1, -1, -1, 0, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 3, 4, 4, 4, 4),
            2 => array(-1, -1, -1, -1, -1, -1, 0, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 3, 4),
            3 => array(-1, -1, -1, -1, -1, -1, -1, -1, -1, 0, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3),
            4 => array(-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 0, 1, 1, 1, 1, 2, 2, 3)
        );

        $ranger = new ClassDefinition();
        $ranger
            ->setName("Ranger")
            ->setHpDice(10)
            ->setSkillPoints(6)
            ->setBab($bab)
            ->setReflexes($reflexes)
            ->setFortitude($fortitude)
            ->setWill($will)
            ->setSpellsPerDay($spellsPerDay);;

        $manager->persist($ranger);
        $manager->flush();

        $this->addReference('ranger', $ranger);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 2;
    }
}
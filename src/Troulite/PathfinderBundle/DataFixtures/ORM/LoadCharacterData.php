<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troulite\PathfinderBundle\Entity\Character;
use Troulite\PathfinderBundle\Entity\Level;

class LoadCharacterData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $gwendae = new Character();
        $gwendae
            ->setName("Gwendaë")
            ->setRace($this->getReference('elf'))
            ->setFavoredClass($this->getReference('ranger'))
            ->setBaseStrength(10)
            ->setBaseDexterity(16)
            ->setBaseConstitution(12)
            ->setBaseIntelligence(10)
            ->setBaseWisdom(13)
            ->setBaseCharisma(10)
            ->addLevel(
                (new Level())
                    ->setClassDefinition($this->getReference('ranger'))
                    ->setLevel(1)
                    ->setHpRoll(10)
                    ->setExtraHp(1)
            )
            ->addLevel(
                (new Level())
                    ->setClassDefinition($this->getReference('ranger'))
                    ->setLevel(2)
                    ->setHpRoll(5)
                    ->setExtraHp(1)
            )
            ->addLevel(
                (new Level())
                    ->setClassDefinition($this->getReference('ranger'))
                    ->setLevel(3)
                    ->setHpRoll(2)
                    ->setExtraHp(1)
            )
            ->addLevel(
                (new Level())
                    ->setClassDefinition($this->getReference('ranger'))
                    ->setLevel(4)
                    ->setHpRoll(4)
                    ->setExtraHp(1)
                    ->setModifiers(array("dexterity" => 1))
            )
            ->addLevel(
                (new Level())
                    ->setClassDefinition($this->getReference('ranger'))
                    ->setLevel(5)
                    ->setHpRoll(4)
                    ->setExtraHp(1)
            )
            ->addLevel(
                (new Level())
                    ->setClassDefinition($this->getReference('ranger'))
                    ->setLevel(6)
                    ->setHpRoll(7)
                    ->setExtraHp(1)
            )
            ->addLevel(
                (new Level())
                    ->setClassDefinition($this->getReference('ranger'))
                    ->setLevel(7)
                    ->setHpRoll(6)
                    ->setExtraHp(1)
            )
            ->addLevel(
                (new Level())
                    ->setClassDefinition($this->getReference('ranger'))
                    ->setLevel(8)
                    ->setHpRoll(2)
                    ->setExtraHp(1)
                    ->setModifiers(array("dexterity" => 1))
            )
            ->addLevel(
                (new Level())
                    ->setClassDefinition($this->getReference('ranger'))
                    ->setLevel(9)
                    ->setHpRoll(3)
                    ->setExtraHp(1)
            )
            ->addLevel(
                (new Level())
                    ->setClassDefinition($this->getReference('ranger'))
                    ->setLevel(10)
                    ->setHpRoll(8)
                    ->setExtraHp(1)
            )
            ->addLevel(
                (new Level())
                    ->setClassDefinition($this->getReference('ranger'))
                    ->setLevel(11)
                    ->setHpRoll(10)
                    ->setExtraHp(1)
            )
            ->addLevel(
                (new Level())
                    ->setClassDefinition($this->getReference('ranger'))
                    ->setLevel(12)
                    ->setHpRoll(9)
                    ->setExtraHp(1)
                    ->setModifiers(array("wisdom" => 1))
            )
            ->addLevel(
                (new Level())
                    ->setClassDefinition($this->getReference('ranger'))
                    ->setLevel(13)
                    ->setHpRoll(1)
                    ->setExtraHp(1)
            );

        $manager->persist($gwendae);
        $manager->flush();

        $this->setReference('gwendae', $gwendae);
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
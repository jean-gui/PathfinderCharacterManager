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

        $halfling = new Race();
        $halfling
            ->setName("Halfling")
            ->setModifiers(
                array(
                    "dexterity" => 2,
                    "charisma" => 2,
                    "strength" => -2
                )
            );

        $manager->persist($halfling);
        $manager->flush();

        $this->addReference('halfling', $halfling);

        $human = new Race();
        $human
            ->setName("Human - Strength")
            ->setModifiers(
                array(
                    "strength" => 2
                )
            );

        $manager->persist($human);
        $manager->flush();

        $this->addReference('human-strength', $human);

        $human = new Race();
        $human
            ->setName("Human - Dexterity")
            ->setModifiers(
                array(
                    "dexterity" => 2
                )
            );

        $manager->persist($human);
        $manager->flush();

        $this->addReference('human-dexterity', $human);

        $human = new Race();
        $human
            ->setName("Human - Constitution")
            ->setModifiers(
                array(
                    "constitution" => 2
                )
            );

        $manager->persist($human);
        $manager->flush();

        $this->addReference('human-constitution', $human);

        $human = new Race();
        $human
            ->setName("Human - Intelligence")
            ->setModifiers(
                array(
                    "intelligence" => 2
                )
            );

        $manager->persist($human);
        $manager->flush();

        $this->addReference('human-intelligence', $human);

        $human = new Race();
        $human
            ->setName("Human - Wisdom")
            ->setModifiers(
                array(
                    "wisdom" => 2
                )
            );

        $manager->persist($human);
        $manager->flush();

        $this->addReference('human-wisdom', $human);

        $human = new Race();
        $human
            ->setName("Human - Charisma")
            ->setModifiers(
                array(
                    "charisma" => 2
                )
            );

        $manager->persist($human);
        $manager->flush();

        $this->addReference('human-charisma', $human);

        $dwarf = new Race();
        $dwarf
            ->setName("Dwarf")
            ->setModifiers(
                array(
                    "constitution" => 2,
                    "wisdom" => 2,
                    "charisma" => -2
                )
            );

        $manager->persist($dwarf);
        $manager->flush();

        $this->addReference('dwarf', $dwarf);

        $gnome = new Race();
        $gnome
            ->setName("Gnome")
            ->setModifiers(
                array(
                    "constitution" => 2,
                    "strength" => -2,
                    "charisma" => 2
                )
            );

        $manager->persist($gnome);
        $manager->flush();

        $this->addReference('gnome', $gnome);

        $halfelf = new Race();
        $halfelf
            ->setName("Half-elf - Strength")
            ->setModifiers(
                array(
                    "strength" => 2
                )
            );

        $manager->persist($halfelf);
        $manager->flush();

        $this->addReference('halfelf-strength', $halfelf);

        $halfelf = new Race();
        $halfelf
            ->setName("Half-elf - Dexterity")
            ->setModifiers(
                array(
                    "dexterity" => 2
                )
            );

        $manager->persist($halfelf);
        $manager->flush();

        $this->addReference('halfelf-dexterity', $halfelf);

        $halfelf = new Race();
        $halfelf
            ->setName("Half-elf - Constitution")
            ->setModifiers(
                array(
                    "constitution" => 2
                )
            );

        $manager->persist($halfelf);
        $manager->flush();

        $this->addReference('halfelf-constitution', $halfelf);

        $halfelf = new Race();
        $halfelf
            ->setName("Half-elf - Intelligence")
            ->setModifiers(
                array(
                    "intelligence" => 2
                )
            );

        $manager->persist($halfelf);
        $manager->flush();

        $this->addReference('halfelf-intelligence', $halfelf);

        $halfelf = new Race();
        $halfelf
            ->setName("Half-elf - Wisdom")
            ->setModifiers(
                array(
                    "wisdom" => 2
                )
            );

        $manager->persist($halfelf);
        $manager->flush();

        $this->addReference('halfelf-wisdom', $halfelf);

        $halfelf = new Race();
        $halfelf
            ->setName("Half-elf - Charisma")
            ->setModifiers(
                array(
                    "charisma" => 2
                )
            );

        $manager->persist($halfelf);
        $manager->flush();

        $this->addReference('halfelf-charisma', $halfelf);

        $halforc = new Race();
        $halforc
            ->setName("Half-orc - Strength")
            ->setModifiers(
                array(
                    "strength" => 2
                )
            );

        $manager->persist($halforc);
        $manager->flush();

        $this->addReference('halforc-strength', $halforc);

        $halforc = new Race();
        $halforc
            ->setName("Half-orc - Dexterity")
            ->setModifiers(
                array(
                    "dexterity" => 2
                )
            );

        $manager->persist($halforc);
        $manager->flush();

        $this->addReference('halforc-dexterity', $halforc);

        $halforc = new Race();
        $halforc
            ->setName("Half-orc - Constitution")
            ->setModifiers(
                array(
                    "constitution" => 2
                )
            );

        $manager->persist($halforc);
        $manager->flush();

        $this->addReference('halforc-constitution', $halforc);

        $halforc = new Race();
        $halforc
            ->setName("Half-orc - Intelligence")
            ->setModifiers(
                array(
                    "intelligence" => 2
                )
            );

        $manager->persist($halforc);
        $manager->flush();

        $this->addReference('halforc-intelligence', $halforc);

        $halforc = new Race();
        $halforc
            ->setName("Half-orc - Wisdom")
            ->setModifiers(
                array(
                    "wisdom" => 2
                )
            );

        $manager->persist($halforc);
        $manager->flush();

        $this->addReference('halforc-wisdom', $halforc);

        $halforc = new Race();
        $halforc
            ->setName("Half-orc - Charisma")
            ->setModifiers(
                array(
                    "charisma" => 2
                )
            );

        $manager->persist($halforc);
        $manager->flush();

        $this->addReference('halforc-charisma', $halforc);
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
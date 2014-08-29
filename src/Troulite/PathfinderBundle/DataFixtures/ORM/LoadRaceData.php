<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troulite\PathfinderBundle\Entity\Race;

/**
 * Class LoadRaceData
 *
 * @package Troulite\PathfinderBundle\DataFixtures\ORM
 */
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
            ->setTraits(
                array(
                    "dexterity" => ['type' => 'racial', 'value' => 2],
                    "intelligence" => ['type' => 'racial', 'value' => 2],
                    "constitution" => ['type' => 'racial', 'value' => -2],
                    "perception" => ['type' => 'racial', 'value' => 2],
                )
            );

        $manager->persist($elf);
        $manager->flush();

        $this->addReference('elf', $elf);

        $halfling = new Race();
        $halfling
            ->setName("Halfling")
            ->setTraits(
                array(
                    "dexterity" => ['type'  => 'racial', 'value' => 2],
                    "charisma" => ['type'  => 'racial', 'value' => 2],
                    "strength" => ['type' => 'racial', 'value' => -2]
                )
            );

        $manager->persist($halfling);
        $manager->flush();

        $this->addReference('halfling', $halfling);

        $human = new Race();
        $human
            ->setName("Human - Strength")
            ->setTraits(
                array(
                    "strength" => ['type'  => 'racial', 'value' => 2],
                    "extra_feats_per_level" => ['type' => 'racial', 'value' => 'c.getLevel() === 1 ? 1 : 0'],
                    "extra_skills_per_level" => ['type' => 'racial', 'value' => '1']
                )
            );

        $manager->persist($human);
        $manager->flush();

        $this->addReference('human-strength', $human);

        $human = new Race();
        $human
            ->setName("Human - Dexterity")
            ->setTraits(
                array(
                    "dexterity" => ['type' => 'racial', 'value' => 2],
                    "extra_feats_per_level" => ['type' => 'racial', 'value' => 'c.getLevel() === 1 ? 1 : 0'],
                    "extra_skills_per_level" => ['type' => 'racial', 'value' => '1']
                )
            );

        $manager->persist($human);
        $manager->flush();

        $this->addReference('human-dexterity', $human);

        $human = new Race();
        $human
            ->setName("Human - Constitution")
            ->setTraits(
                array(
                    "constitution" => ['type' => 'racial', 'value' => 2],
                    "extra_feats_per_level" => ['type' => 'racial', 'value' => 'c.getLevel() === 1 ? 1 : 0'],
                    "extra_skills_per_level" => ['type' => 'racial', 'value' => '1']
                )
            );

        $manager->persist($human);
        $manager->flush();

        $this->addReference('human-constitution', $human);

        $human = new Race();
        $human
            ->setName("Human - Intelligence")
            ->setTraits(
                array(
                    "intelligence" => ['type' => 'racial', 'value' => 2],
                    "extra_feats_per_level" => ['type' => 'racial', 'value' => 'c.getLevel() === 1 ? 1 : 0'],
                    "extra_skills_per_level" => ['type' => 'racial', 'value' => '1']
                )
            );

        $manager->persist($human);
        $manager->flush();

        $this->addReference('human-intelligence', $human);

        $human = new Race();
        $human
            ->setName("Human - Wisdom")
            ->setTraits(
                array(
                    "wisdom" => ['type' => 'racial', 'value' => 2],
                    "extra_feats_per_level" => ['type' => 'racial', 'value' => 'c.getLevel() === 1 ? 1 : 0'],
                    "extra_skills_per_level" => ['type' => 'racial', 'value' => '1']
                )
            );

        $manager->persist($human);
        $manager->flush();

        $this->addReference('human-wisdom', $human);

        $human = new Race();
        $human
            ->setName("Human - Charisma")
            ->setTraits(
                array(
                    "charisma" => ['type' => 'racial', 'value' => 2],
                    "extra_feats_per_level" => ['type' => 'racial', 'value' => 'c.getLevel() === 1 ? 1 : 0'],
                    "extra_skills_per_level" => ['type' => 'racial', 'value' => '1']
                )
            );

        $manager->persist($human);
        $manager->flush();

        $this->addReference('human-charisma', $human);

        $dwarf = new Race();
        $dwarf
            ->setName("Dwarf")
            ->setTraits(
                array(
                    "constitution" => [
                        'type'  => 'racial',
                        'value' => 2],
                    "wisdom" => [
                        'type'  => 'racial',
                        'value' => 2],
                    "charisma" => ['type' => 'racial', 'value' => -2]
                )
            );

        $manager->persist($dwarf);
        $manager->flush();

        $this->addReference('dwarf', $dwarf);

        $gnome = new Race();
        $gnome
            ->setName("Gnome")
            ->setTraits(
                array(
                    "constitution" => [
                        'type'  => 'racial',
                        'value' => 2],
                    "strength" => [
                        'type'  => 'racial',
                        'value' => -2],
                    "charisma" => ['type' => 'racial', 'value' => 2]
                )
            );

        $manager->persist($gnome);
        $manager->flush();

        $this->addReference('gnome', $gnome);

        $halfelf = new Race();
        $halfelf
            ->setName("Half-elf - Strength")
            ->setTraits(
                array(
                    "strength" => ['type' => 'racial', 'value' => 2]
                )
            );

        $manager->persist($halfelf);
        $manager->flush();

        $this->addReference('halfelf-strength', $halfelf);

        $halfelf = new Race();
        $halfelf
            ->setName("Half-elf - Dexterity")
            ->setTraits(
                array(
                    "dexterity" => ['type' => 'racial', 'value' => 2]
                )
            );

        $manager->persist($halfelf);
        $manager->flush();

        $this->addReference('halfelf-dexterity', $halfelf);

        $halfelf = new Race();
        $halfelf
            ->setName("Half-elf - Constitution")
            ->setTraits(
                array(
                    "constitution" => ['type' => 'racial', 'value' => 2]
                )
            );

        $manager->persist($halfelf);
        $manager->flush();

        $this->addReference('halfelf-constitution', $halfelf);

        $halfelf = new Race();
        $halfelf
            ->setName("Half-elf - Intelligence")
            ->setTraits(
                array(
                    "intelligence" => ['type' => 'racial', 'value' => 2]
                )
            );

        $manager->persist($halfelf);
        $manager->flush();

        $this->addReference('halfelf-intelligence', $halfelf);

        $halfelf = new Race();
        $halfelf
            ->setName("Half-elf - Wisdom")
            ->setTraits(
                array(
                    "wisdom" => ['type' => 'racial', 'value' => 2]
                )
            );

        $manager->persist($halfelf);
        $manager->flush();

        $this->addReference('halfelf-wisdom', $halfelf);

        $halfelf = new Race();
        $halfelf
            ->setName("Half-elf - Charisma")
            ->setTraits(
                array(
                    "charisma" => ['type' => 'racial', 'value' => 2]
                )
            );

        $manager->persist($halfelf);
        $manager->flush();

        $this->addReference('halfelf-charisma', $halfelf);

        $halforc = new Race();
        $halforc
            ->setName("Half-orc - Strength")
            ->setTraits(
                array(
                    "strength" => ['type' => 'racial', 'value' => 2]
                )
            );

        $manager->persist($halforc);
        $manager->flush();

        $this->addReference('halforc-strength', $halforc);

        $halforc = new Race();
        $halforc
            ->setName("Half-orc - Dexterity")
            ->setTraits(
                array(
                    "dexterity" => ['type' => 'racial', 'value' => 2]
                )
            );

        $manager->persist($halforc);
        $manager->flush();

        $this->addReference('halforc-dexterity', $halforc);

        $halforc = new Race();
        $halforc
            ->setName("Half-orc - Constitution")
            ->setTraits(
                array(
                    "constitution" => ['type' => 'racial', 'value' => 2]
                )
            );

        $manager->persist($halforc);
        $manager->flush();

        $this->addReference('halforc-constitution', $halforc);

        $halforc = new Race();
        $halforc
            ->setName("Half-orc - Intelligence")
            ->setTraits(
                array(
                    "intelligence" => ['type' => 'racial', 'value' => 2]
                )
            );

        $manager->persist($halforc);
        $manager->flush();

        $this->addReference('halforc-intelligence', $halforc);

        $halforc = new Race();
        $halforc
            ->setName("Half-orc - Wisdom")
            ->setTraits(
                array(
                    "wisdom" => ['type' => 'racial', 'value' => 2]
                )
            );

        $manager->persist($halforc);
        $manager->flush();

        $this->addReference('halforc-wisdom', $halforc);

        $halforc = new Race();
        $halforc
            ->setName("Half-orc - Charisma")
            ->setTraits(
                array(
                    "charisma" => ['type' => 'racial', 'value' => 2]
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
        return 6;
    }
}
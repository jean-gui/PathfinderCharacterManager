<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troulite\PathfinderBundle\Entity\Feat;

class LoadFeatData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $deadlyAim = new Feat();
        $deadlyAim
            ->setName("Deadly aim")
            ->setDescription(
                "You can make exceptionally deadly ranged attacks by pinpointing a foe's weak spot, at the expense of making the attack less likely to succeed."
            )
            ->setPrerequisities(
                array(
                    "dexterity" => 13,
                    "bab" => 1
                )
            )
            ->setPassive(false)
            ->setEffect(
                array(
                    "attack-roll" => "-1 - div(c.getBab(), 4)",
                    "damage-roll" => "2 + 2 * div(c.getBab(), 4)"
                )
            )
            ->setWorksIf(
                array(
                    "attack-type" => "ranged"
                )
            );
        $manager->persist($deadlyAim);
        $this->addReference('deadly-aim', $deadlyAim);

        $lightningReflexes = new Feat();
        $lightningReflexes
            ->setName("Lightning reflexes")
            ->setDescription("You have faster reflexes than normal.")
            ->setPassive(true)
            ->setEffect(
                array(
                    "reflexes" => 2
                )
            );
        $manager->persist($lightningReflexes);
        $this->addReference('lightning-reflexes', $lightningReflexes);

        $rapidShot = new Feat();
        $rapidShot
            ->setName('Rapid shot')
            ->setDescription('You can make an additional ranged attack.')
            ->setPassive(false)
            ->setEffect(
                array(
                    'attacks' => 1,
                    'attack-roll' => -2
                )
            )
            ->setWorksIf(
                array(
                    "attack-type" => "ranged"
                )
            );
        $manager->persist($rapidShot);
        $this->addReference('rapid-shot', $rapidShot);

        $weaponFocus = new Feat();
        $weaponFocus
            ->setName('Weapon focus - Longbow')
            ->setDescription(
                'Choose one type of weapon. You can also choose unarmed strike or grapple (or ray, if you are a spellcaster) as your weapon for the purposes of this feat.'
            )
            ->setPassive(false)
            ->setEffect(
                array(
                    'attack-roll' => 1
                )
            )
            ->setWorksIf(
                array(
                    "attack-type" => "ranged",
                    'weapon-type' => 'longbow'
                )
            );
        $manager->persist($weaponFocus);
        $this->addReference('weapon-focus', $weaponFocus);

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
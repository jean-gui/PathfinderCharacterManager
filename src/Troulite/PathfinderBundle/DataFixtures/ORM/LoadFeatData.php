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
                    "bab"       => 1
                )
            )
            ->setPassive(false)
            ->setEffect(
                array(
                    "ranged-attack-roll" => "-1 - div(c.getBab(), 4)",
                    "ranged-damage-roll" => "2 + 2 * div(c.getBab(), 4)"
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

        $ironwill = new Feat();
        $ironwill
            ->setName("Iron will")
            ->setDescription("You are more resistant to mental effects.")
            ->setPassive(true)
            ->setEffect(
                array(
                    "will" => 2
                )
            );
        $manager->persist($ironwill);
        $this->addReference('iron-will', $ironwill);

        $greatFortitude = new Feat();
        $greatFortitude
            ->setName("Great Fortitude")
            ->setDescription("You are resistant to poisons, diseases, and other maladies.")
            ->setPassive(true)
            ->setEffect(
                array(
                    "fortitude" => 2
                )
            );
        $manager->persist($greatFortitude);
        $this->addReference('great-fortitude', $greatFortitude);

        $rapidShot = new Feat();
        $rapidShot
            ->setName('Rapid shot')
            ->setDescription('You can make an additional ranged attack.')
            ->setPassive(false)
            ->setEffect(
                array(
                    'ranged-attacks'     => 1,
                    'ranged-attack-roll' => -2
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
                    'ranged-attack-roll' => 1
                )
            )
            ->setWorksIf(
                array(
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
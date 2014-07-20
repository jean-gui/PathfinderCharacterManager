<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troulite\PathfinderBundle\Entity\Feat;

/**
 * Class LoadFeatData
 *
 * @package Troulite\PathfinderBundle\DataFixtures\ORM
 */
class
LoadFeatData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $feat = new Feat();
        $feat
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
                    "ranged-attack-roll" => ['type' => null, 'value' => "-1 - div(c.getBab(), 4)"],
                    "ranged-damage-roll" => ['type' => null, 'value' => "2 + 2 * div(c.getBab(), 4)"]
                )
            );
        $manager->persist($feat);
        $this->addReference('deadly-aim', $feat);

        $feat = new Feat();
        $feat
            ->setName("Lightning reflexes")
            ->setDescription("You have faster reflexes than normal.")
            ->setPassive(true)
            ->setEffect(
                array(
                    "reflexes" => ['type' => null, 'value' => 2]
                )
            );
        $manager->persist($feat);
        $this->addReference('lightning-reflexes', $feat);

        $feat = new Feat();
        $feat
            ->setName("Iron will")
            ->setDescription("You are more resistant to mental effects.")
            ->setPassive(true)
            ->setEffect(
                array(
                    "will" => ['type' => null, 'value' => 2]
                )
            );
        $manager->persist($feat);
        $this->addReference('iron-will', $feat);

        $feat = new Feat();
        $feat
            ->setName("Great Fortitude")
            ->setDescription("You are resistant to poisons, diseases, and other maladies.")
            ->setPassive(true)
            ->setEffect(
                array(
                    "fortitude" => ['type' => null, 'value' => 2]
                )
            );
        $manager->persist($feat);
        $this->addReference('great-fortitude', $feat);

        $feat = new Feat();
        $feat
            ->setName('Rapid shot')
            ->setDescription('You can make an additional ranged attack.')
            ->setPassive(false)
            ->setEffect(
                array(
                    'ranged-attacks'     => ['type' => null, 'value' => 1],
                    'ranged-attack-roll' => ['type' => null, 'value' => -2]
                )
            );
        $manager->persist($feat);
        $this->addReference('rapid-shot', $feat);

        $feat = new Feat();
        $feat
            ->setName('Weapon focus - Longbow')
            ->setDescription(
                'Choose one type of weapon. You can also choose unarmed strike or grapple (or ray, if you are a spellcaster) as your weapon for the purposes of this feat.'
            )
            ->setPassive(true)
            ->setEffect(
                array(
                    'ranged-attack-roll' => ['type' => null, 'value' => 1]
                )
            )
            ->setConditions(
                array(
                    'weapon-type' => 'longbow'
                )
            );
        $manager->persist($feat);
        $this->addReference('weapon-focus-longbow', $feat);

        $feat = new Feat();
        $feat
            ->setName('Weapon focus - Longsword')
            ->setDescription(
                'Choose one type of weapon. You can also choose unarmed strike or grapple (or ray, if you are a spellcaster) as your weapon for the purposes of this feat.'
            )
            ->setPassive(true)
            ->setEffect(
                array(
                    'ranged-attack-roll' => ['type' => null, 'value' => 1]
                )
            )
            ->setConditions(
                array(
                    'weapon-type' => 'longsword'
                )
            );
        $manager->persist($feat);
        $this->addReference('weapon-focus-longsword', $feat);

        $feat = new Feat();
        $feat
            ->setName('Dodge')
            ->setDescription(
                "Your training and reflexes allow you to react swiftly to avoid an opponents' attacks ."
            )
            ->setPassive(true)
            ->setPrerequisities(
                array("dexterity" => 13)
            )
            ->setEffect(
                array(
                    'ac' => ['type' => 'dodge', 'value' => 1]
                )
            );
        $manager->persist($feat);
        $this->addReference('dodge', $feat);

        $feat = new Feat();
        $feat
            ->setName('Point-Blank Shot')
            ->setDescription(
                'You are especially accurate when making ranged attacks against close targets.'
            )
            ->setPassive(true)
            ->setEffect(
                array(
                    'ranged-damage-roll' => ['type' => null, 'value' => 1],
                    'ranged-attack-roll' => ['type' => null, 'value' => 1],
                )
            )
            ->setExternalConditions(
                array('target-distance' => '< 9')
            );
        $manager->persist($feat);
        $this->addReference('pointBlankShot', $feat);

        $feat = new Feat();
        $feat
            ->setName('Toughness')
            ->setDescription('You have enhanced physical stamina.')
            ->setPassive(true)
            ->setEffect(
                array(
                    'hp' => ['type' => null, 'value' => 'c.getLevel() <= 3 ? 3 : c.getLevel()']
                )
            );
        $manager->persist($feat);
        $this->addReference('toughness', $feat);

        $feat = new Feat();
        $feat
            ->setName('Shield Focus')
            ->setDescription('You are skilled at deflecting blows with your shield.')
            ->setPassive(true)
            ->setEffect(
                array(
                    'ac' => ['type' => null, 'value' => 1]
                )
            )
            ->setConditions(
                array('equipped' => 'shield')
            )
        ;
        $manager->persist($feat);
        $this->addReference('shield-focus', $feat);

        $feat = new Feat();
        $feat
            ->setName('Improved Critical (Longsword)')
            ->setDescription('Attacks made with your chosen weapon are quite deadly.')
            ->setPassive(true)
            ->setEffect(
                array(
                    'critical-range' => ['type' => null, 'value' => 2]
                )
            )
            ->setConditions(
                array('weapon-type' => 'longsword')
            );
        $manager->persist($feat);
        $this->addReference('improved-critical-longsword', $feat);

        $feat = new Feat();
        $feat
            ->setName('Critical Focus')
            ->setDescription('You are trained in the art of causing pain.')
            ->setPassive(true)
            ->setEffect(
                array(
                    'critical-confirmation' => ['type' => null, 'value' => 4]
                )
            );
        $manager->persist($feat);
        $this->addReference('critical-focus', $feat);

        $manager->flush();

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
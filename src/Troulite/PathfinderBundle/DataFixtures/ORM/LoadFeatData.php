<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
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
            ->setShortDescription(
                "You can make exceptionally deadly ranged attacks by pinpointing a foe's weak spot, at the expense of making the attack less likely to succeed."
            )
            ->setPrerequisities(
                array(
                    "dexterity" => 13,
                    "bab"       => 1
                )
            )
            ->setPassive(false)
            ->setEffects(
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
            ->setShortDescription("You have faster reflexes than normal.")
            ->setPassive(true)
            ->setEffects(
                array(
                    "reflexes" => ['type' => null, 'value' => 2]
                )
            );
        $manager->persist($feat);
        $this->addReference('lightning-reflexes', $feat);

        $feat = new Feat();
        $feat
            ->setName("Iron will")
            ->setShortDescription("You are more resistant to mental effects.")
            ->setPassive(true)
            ->setEffects(
                array(
                    "will" => ['type' => null, 'value' => 2]
                )
            );
        $manager->persist($feat);
        $this->addReference('iron-will', $feat);

        $feat = new Feat();
        $feat
            ->setName("Great Fortitude")
            ->setShortDescription("You are resistant to poisons, diseases, and other maladies.")
            ->setPassive(true)
            ->setEffects(
                array(
                    "fortitude" => ['type' => null, 'value' => 2]
                )
            );
        $manager->persist($feat);
        $this->addReference('great-fortitude', $feat);

        $feat = new Feat();
        $feat
            ->setName('Rapid shot')
            ->setShortDescription('You can make an additional ranged attack.')
            ->setLongDescription('
                When making a full-attack action with a ranged weapon, you can fire one additional time this
                round. All of your attack rolls take a –2 penalty when using Rapid Shot.')
            ->setPassive(false)
            ->setEffects(
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
            ->setShortDescription(
                'Choose one type of weapon. You can also choose unarmed strike or grapple (or ray, if you are a spellcaster) as your weapon for the purposes of this feat.'
            )
            ->setPassive(true)
            ->setEffects(
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
            ->setShortDescription(
                'Choose one type of weapon. You can also choose unarmed strike or grapple (or ray, if you are a spellcaster) as your weapon for the purposes of this feat.'
            )
            ->setPassive(true)
            ->setEffects(
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
            ->setName('Weapon focus - Greatsword')
            ->setShortDescription(
                'Choose one type of weapon. You can also choose unarmed strike or grapple (or ray, if you are a spellcaster) as your weapon for the purposes of this feat.'
            )
            ->setPassive(true)
            ->setEffects(
                array(
                    'melee-attack-roll' => ['type' => null, 'value' => 1]
                )
            )
            ->setConditions(
                array(
                    'weapon-type' => 'greatsword'
                )
            );
        $manager->persist($feat);
        $this->addReference('weapon-focus-greatsword', $feat);

        $feat = new Feat();
        $feat
            ->setName('Weapon focus - Whip')
            ->setShortDescription(
                'Choose one type of weapon. You can also choose unarmed strike or grapple (or ray, if you are a spellcaster) as your weapon for the purposes of this feat.'
            )
            ->setPassive(true)
            ->setEffects(
                array(
                    'ranged-attack-roll' => ['type' => null, 'value' => 1]
                )
            )
            ->setConditions(
                array(
                    'weapon-type' => 'whip'
                )
            );
        $manager->persist($feat);
        $this->addReference('weapon-focus-whip', $feat);

        $feat = new Feat();
        $feat
            ->setName('Dodge')
            ->setShortDescription(
                "Your training and reflexes allow you to react swiftly to avoid an opponents' attacks ."
            )
            ->setPassive(true)
            ->setPrerequisities(
                array("dexterity" => 13)
            )
            ->setEffects(
                array(
                    'ac' => ['type' => 'dodge', 'value' => 1]
                )
            );
        $manager->persist($feat);
        $this->addReference('dodge', $feat);

        $feat = new Feat();
        $feat
            ->setName('Point-Blank Shot')
            ->setShortDescription(
                'You are especially accurate when making ranged attacks against close targets.'
            )
            ->setPassive(true)
            ->setEffects(
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
            ->setShortDescription('You have enhanced physical stamina.')
            ->setPassive(true)
            ->setEffects(
                array(
                    'hp' => ['type' => null, 'value' => 'c.getLevel() <= 3 ? 3 : c.getLevel()']
                )
            );
        $manager->persist($feat);
        $this->addReference('toughness', $feat);

        $feat = new Feat();
        $feat
            ->setName('Shield Focus')
            ->setShortDescription('You are skilled at deflecting blows with your shield.')
            ->setPassive(true)
            ->setEffects(
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
            ->setShortDescription('Attacks made with your chosen weapon are quite deadly.')
            ->setPassive(true)
            ->setEffects(
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
            ->setName('Improved Critical (Greatsword)')
            ->setShortDescription('Attacks made with your chosen weapon are quite deadly.')
            ->setPassive(true)
            ->setEffects(
                array(
                    'critical-range' => ['type' => null, 'value' => 2]
                )
            )
            ->setConditions(
                array('weapon-type' => 'greatsword')
            );
        $manager->persist($feat);
        $this->addReference('improved-critical-greatsword', $feat);

        $feat = new Feat();
        $feat
            ->setName('Critical Focus')
            ->setShortDescription('You are trained in the art of causing pain.')
            ->setPassive(true)
            ->setEffects(
                array(
                    'critical-confirmation' => ['type' => null, 'value' => 4]
                )
            );
        $manager->persist($feat);
        $this->addReference('critical-focus', $feat);

        $feat = new Feat();
        $feat
            ->setName('Endurance')
            ->setShortDescription('Harsh conditions or long exertions do not easily tire you.')
            ->setPassive(false)
            ->setEffects(
                array(
                    'swim' => ['type' => null, 'value' => 4],
                    'fortitude' => ['type' => null, 'value' => 4]
                )
            );
        $manager->persist($feat);
        $this->addReference('feat-endurance', $feat);

        $feat = new Feat();
        $feat
            ->setName('Weapon Finesse')
            ->setShortDescription('You are trained in using your agility in melee combat, as opposed to brute strength.')
            ->setLongDescription('
                With a light weapon, elven curve blade, rapier, whip, or spiked chain made for a creature of your size
                category, you may use your Dexterity modifier instead of your Strength modifier on attack rolls. If you
                carry a shield, its armor check penalty applies to your attack rolls.
            ')
            ->setPassive(true)
            ->setEffects(
                array(
                    'melee-attack-rolls' => [
                        'type' => null,
                        'value' => 'c.getAbilityModifier(c.getDexterity()) - c.getAbilityModifier(c.getStrength())'
                    ],
                )
            );
        $manager->persist($feat);
        $this->addReference('feat-weapon-finesse', $feat);

        $finder = new Finder();
        $finder->files()->in('src/Troulite/PathfinderBundle/DataFixtures/ORM/')->name('feats.csv');
        /** @var $file SplFileInfo */
        foreach($finder as $file) {
            $handle = fopen($file->getRealPath(), 'r');
            $header = null;
            while (($row = fgetcsv($handle, null, ',', '"', "\\")) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data = array_combine($header, $row);

                    $feat = new Feat();
                    $feat
                        ->setName($data['name'])
                        ->setShortDescription($data['description'])
                        ->setLongDescription($data['benefit'])
                        ->setPassive(true);
                    if ($data['effects']) {
                        $feat->setEffects($data['effects']);
                    }
                    $manager->persist($feat);
                }
            }
        }

        $manager->flush();
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
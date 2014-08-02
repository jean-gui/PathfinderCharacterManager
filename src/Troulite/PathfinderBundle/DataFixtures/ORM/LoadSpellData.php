<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Troulite\PathfinderBundle\Entity\ClassSpell;
use Troulite\PathfinderBundle\Entity\Spell;

/**
 * Class LoadSpellData
 *
 * @package Troulite\PathfinderBundle\DataFixtures\ORM
 */
class LoadSpellData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $spell = (new Spell())
            ->setName("Cat's Grace")
            ->setLongDescription(
                "The transmuted creature becomes more graceful, agile, and coordinated. The spell grants a +4 enhancement bonus to Dexterity, adding the usual benefits to AC, Reflex saves, and other uses of the Dexterity modifier."
            )
            ->setCastingTime("1 standard action")
            ->setComponents("pinch of cat fur")
            ->setRange("touch")
            ->setTargets("creature touched")
            ->setDuration("1 min./level")
            ->setSavingThrow("Will negates (harmless)")
            ->setSpellResistance(true)
            ->setPassive(true)
            ->setEffects(
                array(
                    'dexterity' => ['type' => 'enhancement', 'value' => 4]
                )
            );
        $manager->persist($spell);
        $this->setReference('spell-cats-grace', $spell);

        $classSpell = (new ClassSpell())->setSpell($spell)->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($spell)->setClass($this->getReference('ranger'))->setSpellLevel(2);
        $manager->persist($classSpell);

        /**
         * @todo Speed bonus limited to 2 times c.speed
         */
        $spell = (new Spell())->setName("Haste")
            ->setShortDescription('One creature/level moves faster, receives +1 on attack rolls, AC, and Reflex saves.')
            ->setLongDescription(
                "
                                The transmuted creatures move and act more quickly than normal. This extra speed has several effects.
                                When making a full attack action, a hasted creature may make one extra attack with one natural or manufactured weapon. The attack is made using the creature's full base attack bonus, plus any modifiers appropriate to the situation . (This effect is not cumulative with similar effects, such as that provided by a speed weapon, nor does it actually grant an extra action, so you can't use it to cast a second spell or otherwise take an extra action in the round.)
                                A hasted creature gains a +1 bonus on attack rolls and a +1 dodge bonus to AC and Reflex saves. Any condition that makes you lose your Dexterity bonus to Armor Class (if any) also makes you lose dodge bonuses.
                                All of the hasted creature's modes of movement(including land movement, burrow, climb, fly, and swim) increase by 30 feet, to a maximum of twice the subject's normal speed using that form of movement. This increase counts as an enhancement bonus, and it affects the creature's jumping distance as normal for increased speed . Multiple haste effects don't stack. Haste dispels and counters slow.
                            "
            )
            ->setCastingTime('1 standard action')
            ->setComponents('V, S, M (a shaving of licorice root)')
            ->setRange('5 + 1 /2 levels')
            ->setTargets('one creature/level, no two of which can be more than 30 ft. apart')
            ->setDuration('1 round/level')
            ->setSavingThrow('Fortitude negates (harmless)')
            ->setSpellResistance(true)
            ->setEffects(
                array(
                    'melee-attacks'      => ['type' => 'haste', 'value' => 1],
                    'ranged-attacks'     => ['type' => 'haste', 'value' => 1],
                    'melee-attack-roll'  => ['type' => 'haste', 'value' => 1],
                    'ranged-attack-roll' => ['type' => 'haste', 'value' => 1],
                    'ac'                 => ['type' => 'dodge', 'value' => 1],
                    'reflexes'           => ['type' => 'dodge', 'value' => 1],
                    'speed'              => ['type' => 'alteration', 'value' => 6]
                )
            )
            ->setPassive(true);
        $manager->persist($spell);

        $classSpell = (new ClassSpell())->setSpell($spell)->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $finder = new Finder();
        $finder->files()->in('src/Troulite/PathfinderBundle/DataFixtures/ORM/')->name('spells.csv');
        /** @var $file SplFileInfo */
        foreach ($finder as $file) {
            $handle = fopen($file->getRealPath(), 'r');
            $header = null;
            while (($row = fgetcsv($handle, null, ',', '"', "\\")) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data = array_combine($header, $row);

                    $spell = new Spell();
                    $spell
                        ->setName($data['name'])
                        ->setShortDescription($data['short_description'])
                        ->setLongDescription($data['description'])
                        ->setCastingTime($data['casting_time'])
                        ->setComponents($data['components'])
                        ->setRange($data['range'])
                        ->setTargets($data['targets'])
                        ->setDuration($data['duration'])
                        ->setSavingThrow($data['saving_throw'])
                        ->setSpellResistance($data['spell_resistence'])
                        ->setPassive(true);
                    $manager->persist($spell);

                    foreach(array('bard', 'paladin', 'ranger') as $className) {
                        if ($data[$className] != 'NULL') {
                            $classSpell = (new ClassSpell())->setSpell($spell)->setClass(
                                $this->getReference($className)
                            )->setSpellLevel($data[$className]);
                            $manager->persist($classSpell);
                        }
                    }
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
        return 3;
    }
}
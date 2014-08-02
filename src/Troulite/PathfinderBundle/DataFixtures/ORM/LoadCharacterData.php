<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troulite\PathfinderBundle\Entity\Abilities;
use Troulite\PathfinderBundle\Entity\Character;
use Troulite\PathfinderBundle\Entity\CharacterClassPower;
use Troulite\PathfinderBundle\Entity\CharacterEquipment;
use Troulite\PathfinderBundle\Entity\CharacterFeat;
use Troulite\PathfinderBundle\Entity\Level;
use Troulite\PathfinderBundle\Entity\LevelSkill;
use Troulite\PathfinderBundle\Entity\PreparedSpell;

/**
 * Class LoadCharacterData
 *
 * @package Troulite\PathfinderBundle\DataFixtures\ORM
 */
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
            ->setUser($this->getReference('jean-gui'))
            ->setParty($this->getReference('sit'))
            ->setRace($this->getReference('elf'))
            ->setFavoredClass($this->getReference('ranger'))
            ->setExtraPoint('hp')
            ->setAbilities(new Abilities(10, 16, 12, 10, 13, 10))
            ->setEquipment(
                (new CharacterEquipment())
                    ->setMainWeapon($this->getReference('longbow +2'))
                    ->setBody($this->getReference('mithral chain mail +5'))
            );

        // Level 1
        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setHpRoll(10)
            ->addFeat(
                (new CharacterFeat())
                    ->setFeat($this->getReference("weapon-focus-longbow"))
            )
            ->addClassPower(
                (new CharacterClassPower())
                    ->setClassPower($this->getReference('favored-enemy-1'))
            )
            ->addClassPower(
                (new CharacterClassPower())
                    ->setClassPower($this->getReference('track'))
            )
            ->addClassPower(
                (new CharacterClassPower())
                    ->setClassPower($this->getReference('wild-empathy'))
            );
        $gwendae->addLevel($level);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('stealth'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('heal'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('survival'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('perception'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('climb'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeNature'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeGeography'))
            ->setValue(1);
        $manager->persist($skill);

        // Level 2
        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setHpRoll(5)
            ->addFeat(
                (new CharacterFeat())
                    ->setFeat($this->getReference("rapid-shot"))
                    ->setActive(false)
            )
            ->addClassPower(
                (new CharacterClassPower())
                    ->setClassPower($this->getReference('combat-style-feat-1'))
            );
        $gwendae->addLevel($level);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('stealth'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('survival'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('perception'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('climb'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeNature'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeGeography'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeDungeoneering'))
            ->setValue(1);
        $manager->persist($skill);

        // Level 3
        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setHpRoll(2)
            ->addFeat(
                (new CharacterFeat())
                    ->setFeat($this->getReference("deadly-aim"))
                    ->setActive(true)
            )
            ->addFeat(
                (new CharacterFeat())
                    ->setFeat($this->getReference("feat-endurance"))
                    ->setActive(false)
            )
            ->addClassPower(
                (new CharacterClassPower())
                    ->setClassPower($this->getReference('endurance'))
            )
            ->addClassPower(
                (new CharacterClassPower())
                    ->setClassPower($this->getReference('favored-terrain-1'))
            );
        $gwendae->addLevel($level);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('stealth'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('survival'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('perception'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('climb'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeNature'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeGeography'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeDungeoneering'))
            ->setValue(1);
        $manager->persist($skill);

        // Level 4
        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setHpRoll(4)
            ->setExtraAbility(Abilities::DEXTERITY)
            ->addClassPower(
                (new CharacterClassPower())
                    ->setClassPower($this->getReference('hunter-bond'))
            );
        $gwendae->addLevel($level);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('stealth'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('survival'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('perception'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('climb'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeNature'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeGeography'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeDungeoneering'))
            ->setValue(1);
        $manager->persist($skill);

        // Level 5
        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setHpRoll(4)
            ->addFeat((new CharacterFeat())->setFeat($this->getReference('pointBlankShot')))
            ->addClassPower(
                (new CharacterClassPower())
                    ->setClassPower($this->getReference('favored-enemy-2'))
            );
        $gwendae->addLevel($level);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('stealth'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('survival'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('perception'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('climb'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeNature'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeGeography'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('disableDevice'))
            ->setValue(1);
        $manager->persist($skill);

        // Level 6
        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setHpRoll(7)
            ->addClassPower(
                (new CharacterClassPower())
                    ->setClassPower($this->getReference('combat-style-feat-2'))
            );
        $gwendae->addLevel($level);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('stealth'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('survival'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('perception'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('climb'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeNature'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeGeography'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('disableDevice'))
            ->setValue(1);
        $manager->persist($skill);

        // Level 7
        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setHpRoll(6)
            ->addClassPower(
                (new CharacterClassPower())
                    ->setClassPower($this->getReference('woodland-stride'))
            );
        $gwendae->addLevel($level);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('stealth'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('survival'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('perception'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('climb'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeNature'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeGeography'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('disableDevice'))
            ->setValue(1);
        $manager->persist($skill);

        // Level 8
        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setHpRoll(2)
            ->setExtraAbility(Abilities::DEXTERITY)
            ->addClassPower(
                (new CharacterClassPower())
                    ->setClassPower($this->getReference('swift-tracker'))
            )
            ->addClassPower(
                (new CharacterClassPower())
                    ->setClassPower($this->getReference('favored-terrain-2'))
            );
        $gwendae->addLevel($level);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('stealth'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('survival'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('perception'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('climb'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeNature'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeGeography'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('disableDevice'))
            ->setValue(1);
        $manager->persist($skill);

        // Level 9
        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setHpRoll(3)
            ->addFeat((new CharacterFeat())->setFeat($this->getReference('dodge')))
            ->addClassPower(
                (new CharacterClassPower())
                    ->setClassPower($this->getReference('evasion'))
            );
        $gwendae->addLevel($level);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('stealth'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('survival'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('perception'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('climb'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeNature'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeGeography'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('disableDevice'))
            ->setValue(1);
        $manager->persist($skill);

        // Level 10
        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setHpRoll(8)
            ->addClassPower(
                (new CharacterClassPower())
                    ->setClassPower($this->getReference('favored-enemy-3'))
            )
            ->addClassPower(
                (new CharacterClassPower())
                    ->setClassPower($this->getReference('combat-style-feat-3'))
            );
        $gwendae->addLevel($level);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('stealth'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('survival'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('perception'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('climb'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeNature'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeGeography'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('disableDevice'))
            ->setValue(1);
        $manager->persist($skill);

        // Level 11
        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setHpRoll(10)
            ->addFeat(
                (new CharacterFeat())
                    ->setFeat($this->getReference("lightning-reflexes"))
            )
            ->addClassPower(
                (new CharacterClassPower())
                    ->setClassPower($this->getReference('quarry'))
            );
        $gwendae->addLevel($level);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('stealth'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('survival'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('perception'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('climb'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeNature'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('disableDevice'))
            ->setValue(2);
        $manager->persist($skill);

        // Level 12
        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setHpRoll(9)
            ->setExtraAbility(Abilities::WISDOM)
            ->addClassPower(
                (new CharacterClassPower())
                    ->setClassPower($this->getReference('camouflage'))
            );
        $gwendae->addLevel($level);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('stealth'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('survival'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('perception'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('climb'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeNature'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('disableDevice'))
            ->setValue(2);
        $manager->persist($skill);

        // Level 13
        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setHpRoll(1)
            ->addFeat(
                (new CharacterFeat())
                    ->setFeat($this->getReference("iron-will"))
            )
            ->addClassPower(
                (new CharacterClassPower())
                    ->setClassPower($this->getReference('favored-terrain-3'))
            );
        $gwendae->addLevel($level);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('stealth'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('survival'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('perception'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('knowledgeNature'))
            ->setValue(1);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('disableDevice'))
            ->setValue(3);
        $manager->persist($skill);

        // Level 14
        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setHpRoll(8)
            ->addClassPower(
                (new CharacterClassPower())
                    ->setClassPower($this->getReference('combat-style-feat-4'))
            );
        $gwendae->addLevel($level);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('acrobatics'))
            ->setValue(6);
        $manager->persist($skill);
        $skill = (new LevelSkill())
            ->setLevel($level)
            ->setSkill($this->getReference('stealth'))
            ->setValue(1);
        $manager->persist($skill);

        $gwendae->addPreparedSpell(new PreparedSpell(
            $gwendae,
            $this->getReference('spell-cats-grace'),
            $this->getReference('ranger')
        ));
        $gwendae->addPreparedSpell(
            new PreparedSpell(
                $gwendae,
                $this->getReference('spell-cats-grace'),
                $this->getReference('ranger')
            )
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
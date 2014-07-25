<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troulite\PathfinderBundle\Entity\Abilities;
use Troulite\PathfinderBundle\Entity\Character;
use Troulite\PathfinderBundle\Entity\CharacterFeat;
use Troulite\PathfinderBundle\Entity\CharacterEquipment;
use Troulite\PathfinderBundle\Entity\Level;
use Troulite\PathfinderBundle\Entity\LevelSkill;

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
            ->setExtraAbility(Abilities::DEXTERITY);
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
            ->addFeat((new CharacterFeat())->setFeat($this->getReference('pointBlankShot')));
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

        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setHpRoll(7);
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

        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setHpRoll(6);
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

        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setHpRoll(2)
            ->setExtraAbility(Abilities::DEXTERITY);
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
            ->addFeat((new CharacterFeat())->setFeat($this->getReference('dodge')));
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
            ->setHpRoll(8);
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

        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setHpRoll(10)
            ->addFeat(
                (new CharacterFeat())
                    ->setFeat($this->getReference("lightning-reflexes"))
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

        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setHpRoll(9)
            ->setExtraAbility(Abilities::WISDOM);
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

        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setHpRoll(1)
            ->addFeat(
                (new CharacterFeat())
                    ->setFeat($this->getReference("iron-will"))
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

        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setHpRoll(8);
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
        return 8;
    }
}
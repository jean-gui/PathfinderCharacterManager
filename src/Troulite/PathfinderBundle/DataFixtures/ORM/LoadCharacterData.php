<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troulite\PathfinderBundle\Entity\Abilities;
use Troulite\PathfinderBundle\Entity\BaseCharacter;
use Troulite\PathfinderBundle\Entity\CharacterFeat;
use Troulite\PathfinderBundle\Entity\Equipment;
use Troulite\PathfinderBundle\Entity\Level;
use Troulite\PathfinderBundle\Entity\LevelSkill;

class LoadCharacterData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $gwendae = new BaseCharacter();
        $gwendae
            ->setName("Gwendaë")
            ->setUser($this->getReference('jean-gui'))
            ->setParty($this->getReference('sit'))
            ->setRace($this->getReference('elf'))
            ->setFavoredClass($this->getReference('ranger'))
            ->setAbilities(new Abilities(10, 16, 12, 10, 13, 10))
            ->addFeat(
                (new CharacterFeat())
                    ->setFeat($this->getReference("deadly-aim"))
                    ->setActive(true)
            )
            ->addFeat(
                (new CharacterFeat())
                    ->setFeat($this->getReference("lightning-reflexes"))
                    ->setActive(true)
            )
            ->addFeat(
                (new CharacterFeat())
                    ->setFeat($this->getReference("rapid-shot"))
                    ->setActive(false)
            )
            ->addFeat(
                (new CharacterFeat())
                    ->setFeat($this->getReference("weapon-focus"))
                    ->setActive(true)
            )
            ->addFeat(
                (new CharacterFeat())
                    ->setFeat($this->getReference("iron-will"))
                    ->setActive(true)
            )
            ->setEquipment((new Equipment())->setMainWeapon($this->getReference('longbow +2')));
        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setLevel(1)
            ->setHpRoll(10)
            ->setExtraHp(1);
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

        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setLevel(2)
            ->setHpRoll(5)
            ->setExtraHp(1);
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

        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setLevel(3)
            ->setHpRoll(2)
            ->setExtraHp(1);
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

        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setLevel(4)
            ->setHpRoll(4)
            ->setExtraHp(1)
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

        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setLevel(5)
            ->setHpRoll(4)
            ->setExtraHp(1);
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
            ->setLevel(6)
            ->setHpRoll(7)
            ->setExtraHp(1);
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
            ->setLevel(7)
            ->setHpRoll(6)
            ->setExtraHp(1);
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
            ->setLevel(8)
            ->setHpRoll(2)
            ->setExtraHp(1)
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

        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setLevel(9)
            ->setHpRoll(3)
            ->setExtraHp(1);
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
            ->setLevel(10)
            ->setHpRoll(8)
            ->setExtraHp(1);
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
            ->setLevel(11)
            ->setHpRoll(10)
            ->setExtraHp(1);
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
            ->setLevel(12)
            ->setHpRoll(9)
            ->setExtraHp(1)
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
            ->setLevel(13)
            ->setHpRoll(1)
            ->setExtraHp(1);
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
            ->setLevel(14)
            ->setHpRoll(8)
            ->setExtraHp(1);
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
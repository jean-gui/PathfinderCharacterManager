<?php

/*
 * Copyright 2015 Jean-Guilhem Rouel
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Troulite\PathfinderBundle\DataFixtures\ORM\UserRelated;

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
 * @package Troulite\PathfinderBundle\DataFixtures\ORM\UserRelated
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
            ->setUser($this->getReference('user1'))
            ->setParty($this->getReference('sit'))
            ->setRace($this->getReference('elf'))
            ->setFavoredClass($this->getReference('ranger'))
            ->setAbilities(new Abilities(10, 16, 12, 10, 13, 10))
            ->setEquipment(
                (new CharacterEquipment())
                    ->setMainWeapon($this->getReference('longbow +2'))
                    ->setArmor($this->getReference('mithral chain mail +5'))
            );

        // Level 1
        $level = (new Level())
            ->setClassDefinition($this->getReference('ranger'))
            ->setValue(1)
            ->setHpRoll(10)
            ->setExtraPoint('hp')
            ->addFeat(
                (new CharacterFeat())
                    ->setFeat($this->getReference("feat - Weapon Focus - Longbow"))
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
            ->setValue(2)
            ->setHpRoll(5)
            ->setExtraPoint('hp')
            ->addFeat(
                (new CharacterFeat())
                    ->setFeat($this->getReference("feat - Rapid Shot"))
                    ->setActive(false)
            )
            ->addClassPower(
                (new CharacterClassPower())
                    ->setClassPower($this->getReference('combat-style'))
                    ->setExtraInformation('Archery')
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
            ->setValue(3)
            ->setHpRoll(2)
            ->setExtraPoint('hp')
            ->addFeat(
                (new CharacterFeat())
                    ->setFeat($this->getReference("feat - Deadly Aim"))
                    ->setActive(true)
            )
            ->addFeat(
                (new CharacterFeat())
                    ->setFeat($this->getReference("feat - Endurance"))
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
            ->setValue(4)
            ->setHpRoll(4)
            ->setExtraPoint('hp')
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
            ->setValue(5)
            ->setHpRoll(4)
            ->setExtraPoint('hp')
            ->addFeat((new CharacterFeat())->setFeat($this->getReference('feat - Point-Blank Shot')))
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
            ->setValue(6)
            ->setHpRoll(7)
            ->setExtraPoint('hp')
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
            ->setValue(7)
            ->setHpRoll(6)
            ->setExtraPoint('hp')
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
            ->setValue(8)
            ->setHpRoll(2)
            ->setExtraPoint('hp')
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
            ->setValue(9)
            ->setHpRoll(3)
            ->setExtraPoint('hp')
            ->addFeat((new CharacterFeat())->setFeat($this->getReference('feat - Dodge')))
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
            ->setValue(10)
            ->setHpRoll(8)
            ->setExtraPoint('hp')
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
            ->setValue(11)
            ->setHpRoll(10)
            ->setExtraPoint('hp')
            ->addFeat(
                (new CharacterFeat())
                    ->setFeat($this->getReference("feat - Lightning Reflexes"))
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
            ->setValue(12)
            ->setHpRoll(9)
            ->setExtraPoint('hp')
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
            ->setValue(13)
            ->setHpRoll(1)
            ->setExtraPoint('hp')
            ->addFeat(
                (new CharacterFeat())
                    ->setFeat($this->getReference("feat - Iron Will"))
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
            ->setValue(14)
            ->setHpRoll(8)
            ->setExtraPoint('hp')
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
        return 14;
    }
}
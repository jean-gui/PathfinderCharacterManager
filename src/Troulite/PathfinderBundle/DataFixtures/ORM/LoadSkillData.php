<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troulite\PathfinderBundle\Entity\Skill;

/**
 * Class LoadSkillData
 *
 * @package Troulite\PathfinderBundle\DataFixtures\ORM
 */
class LoadSkillData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $acrobatics = new Skill();
        $acrobatics
            ->setName('Acrobatics')
            ->setArmorCheckPenalty(true)
            ->setKeyAbility('dexterity');

        $appraise = new Skill();
        $appraise
            ->setName('Appraise')
            ->setUntrained(true)
            ->setKeyAbility('intelligence');
        $bluff = new Skill();
        $bluff
            ->setName('Bluff')
            ->setKeyAbility('charisma');
        $climb = new Skill();
        $climb
            ->setName('Climb')
            ->setArmorCheckPenalty(true)
            ->setKeyAbility('strength');
        $craft = new Skill();
        $craft
            ->setName('Craft')
            ->setKeyAbility('intelligence');
        $diplomacy = new Skill();
        $diplomacy
            ->setName('Diplomacy')
            ->setKeyAbility('charisma');
        $disableDevice = new Skill();
        $disableDevice
            ->setName('Disable Device')
            ->setArmorCheckPenalty(true)
            ->setUntrained(false)
            ->setKeyAbility('dexterity');
        $disguise = new Skill();
        $disguise
            ->setName('Disguise')
            ->setKeyAbility('charisma');
        $escapeArtist = new Skill();
        $escapeArtist
            ->setName('Escape Artist')
            ->setArmorCheckPenalty(true)
            ->setKeyAbility('dexterity');
        $fly = new Skill();
        $fly
            ->setName('Fly')
            ->setArmorCheckPenalty(true)
            ->setKeyAbility('dexterity');
        $handleAnimal = new Skill();
        $handleAnimal
            ->setName('Handle Animal')
            ->setUntrained(false)
            ->setKeyAbility('charisma');
        $heal = new Skill();
        $heal
            ->setName('Heal')
            ->setKeyAbility('wisdom');
        $intimidate = new Skill();
        $intimidate
            ->setName('Intimidate')
            ->setKeyAbility('charisma');
        $knowledgeArcana = new Skill();
        $knowledgeArcana
            ->setName('Knowledge (Arcana)')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $knowledgeDungeoneering = new Skill();
        $knowledgeDungeoneering
            ->setName('Knowledge (Dungeoneering)')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $knowledgeEngineering = new Skill();
        $knowledgeEngineering
            ->setName('Knowledge (Engineering)')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $knowledgeGeography = new Skill();
        $knowledgeGeography
            ->setName('Knowledge (Geography)')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $knowledgeHistory = new Skill();
        $knowledgeHistory
            ->setName('Knowledge (History)')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $knowledgeLocal = new Skill();
        $knowledgeLocal
            ->setName('Knowledge (Local)')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $knowledgeNature = new Skill();
        $knowledgeNature
            ->setName('Knowledge (Nature)')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $knowledgeNobility = new Skill();
        $knowledgeNobility
            ->setName('Knowledge (Nobility)')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $knowledgePlanes = new Skill();
        $knowledgePlanes
            ->setName('Knowledge (Planes)')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $knowledgeReligion = new Skill();
        $knowledgeReligion
            ->setName('Knowledge (Religion)')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $linguistics = new Skill();
        $linguistics
            ->setName('Linguistics')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $perception = new Skill();
        $perception
            ->setName('Perception')
            ->setKeyAbility('wisdom');
        $perform = new Skill();
        $perform
            ->setName('Perform')
            ->setKeyAbility('charisma');
        $profession = new Skill();
        $profession
            ->setName('Profession')
            ->setUntrained(false)
            ->setKeyAbility('wisdom');
        $ride = new Skill();
        $ride
            ->setName('Ride')
            ->setArmorCheckPenalty(true)
            ->setKeyAbility('dexterity');
        $senseMotive = new Skill();
        $senseMotive
            ->setName('Sense Motive')
            ->setKeyAbility('wisdom');
        $sleightOfHand = new Skill();
        $sleightOfHand
            ->setName('Sleight of Hand')
            ->setUntrained(false)
            ->setKeyAbility('dexterity');
        $spellcraft = new Skill();
        $spellcraft
            ->setName('Spellcraft')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $stealth = new Skill();
        $stealth
            ->setName('Stealth')
            ->setArmorCheckPenalty(true)
            ->setKeyAbility('dexterity');
        $survival = new Skill();
        $survival
            ->setName('Survival')
            ->setKeyAbility('wisdom');
        $swim = new Skill();
        $swim
            ->setName('Swim')
            ->setArmorCheckPenalty(true)
            ->setKeyAbility('strength');
        $useMagicDevice = new Skill();
        $useMagicDevice
            ->setName('Use Magic Device')
            ->setUntrained(false)
            ->setKeyAbility('charisma');

        $manager->persist($acrobatics);
        $this->setReference('acrobatics', $acrobatics);
        $manager->persist($appraise);
        $this->setReference('appraise', $appraise);
        $manager->persist($bluff);
        $this->setReference('bluff', $bluff);
        $manager->persist($climb);
        $this->setReference('climb', $climb);
        $manager->persist($craft);
        $this->setReference('craft', $craft);
        $manager->persist($diplomacy);
        $this->setReference('diplomacy', $diplomacy);
        $manager->persist($disableDevice);
        $this->setReference('disableDevice', $disableDevice);
        $manager->persist($disguise);
        $this->setReference('disguise', $disguise);
        $manager->persist($escapeArtist);
        $this->setReference('escapeArtist', $escapeArtist);
        $manager->persist($fly);
        $this->setReference('fly', $fly);
        $manager->persist($handleAnimal);
        $this->setReference('handleAnimal', $handleAnimal);
        $manager->persist($heal);
        $this->setReference('heal', $heal);
        $manager->persist($intimidate);
        $this->setReference('intimidate', $intimidate);
        $manager->persist($knowledgeArcana);
        $this->setReference('knowledgeArcana', $knowledgeArcana);
        $manager->persist($knowledgeDungeoneering);
        $this->setReference('knowledgeDungeoneering', $knowledgeDungeoneering);
        $manager->persist($knowledgeEngineering);
        $this->setReference('knowledgeEngineering', $knowledgeEngineering);
        $manager->persist($knowledgeGeography);
        $this->setReference('knowledgeGeography', $knowledgeGeography);
        $manager->persist($knowledgeHistory);
        $this->setReference('knowledgeHistory', $knowledgeHistory);
        $manager->persist($knowledgeLocal);
        $this->setReference('knowledgeLocal', $knowledgeLocal);
        $manager->persist($knowledgeNature);
        $this->setReference('knowledgeNature', $knowledgeNature);
        $manager->persist($knowledgeNobility);
        $this->setReference('knowledgeNobility', $knowledgeNobility);
        $manager->persist($knowledgePlanes);
        $this->setReference('knowledgePlanes', $knowledgePlanes);
        $manager->persist($knowledgeReligion);
        $this->setReference('knowledgeReligion', $knowledgeReligion);
        $manager->persist($linguistics);
        $this->setReference('linguistics', $linguistics);
        $manager->persist($perception);
        $this->setReference('perception', $perception);
        $manager->persist($perform);
        $this->setReference('perform', $perform);
        $manager->persist($profession);
        $this->setReference('profession', $profession);
        $manager->persist($ride);
        $this->setReference('ride', $ride);
        $manager->persist($senseMotive);
        $this->setReference('senseMotive', $senseMotive);
        $manager->persist($sleightOfHand);
        $this->setReference('sleightOfHand', $sleightOfHand);
        $manager->persist($spellcraft);
        $this->setReference('spellcraft', $spellcraft);
        $manager->persist($stealth);
        $this->setReference('stealth', $stealth);
        $manager->persist($survival);
        $this->setReference('survival', $survival);
        $manager->persist($swim);
        $this->setReference('swim', $swim);
        $manager->persist($useMagicDevice);
        $this->setReference('useMagicDevice', $useMagicDevice);

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
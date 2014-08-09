<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Gedmo\Translatable\Entity\Repository\TranslationRepository;
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
        /** @var $translationsRepository TranslationRepository */
        $translationsRepository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        $acrobatics = new Skill();
        $acrobatics
            ->setName('Acrobatics')
            ->setArmorCheckPenalty(true)
            ->setKeyAbility('dexterity');
        $translationsRepository->translate($acrobatics, 'name', 'fr', 'Acrobaties');

        $appraise = new Skill();
        $appraise
            ->setName('Appraise')
            ->setUntrained(true)
            ->setKeyAbility('intelligence');
        $translationsRepository->translate($appraise, 'name', 'fr', 'Estimation');

        $bluff = new Skill();
        $bluff
            ->setName('Bluff')
            ->setKeyAbility('charisma');
        $translationsRepository->translate($bluff, 'name', 'fr', 'Bluff');

        $climb = new Skill();
        $climb
            ->setName('Climb')
            ->setArmorCheckPenalty(true)
            ->setKeyAbility('strength');
        $translationsRepository->translate($climb, 'name', 'fr', 'Escalade');

        $craft = new Skill();
        $craft
            ->setName('Craft')
            ->setKeyAbility('intelligence');
        $translationsRepository->translate($craft, 'name', 'fr', 'Artisanat');

        $diplomacy = new Skill();
        $diplomacy
            ->setName('Diplomacy')
            ->setKeyAbility('charisma');
        $translationsRepository->translate($diplomacy, 'name', 'fr', 'Diplomatie');

        $disableDevice = new Skill();
        $disableDevice
            ->setName('Disable Device')
            ->setArmorCheckPenalty(true)
            ->setUntrained(false)
            ->setKeyAbility('dexterity');
        $translationsRepository->translate($disableDevice, 'name', 'fr', 'Sabotage');

        $disguise = new Skill();
        $disguise
            ->setName('Disguise')
            ->setKeyAbility('charisma');
        $translationsRepository->translate($disguise, 'name', 'fr', 'Déguisement');

        $escapeArtist = new Skill();
        $escapeArtist
            ->setName('Escape Artist')
            ->setArmorCheckPenalty(true)
            ->setKeyAbility('dexterity');
        $translationsRepository->translate($escapeArtist, 'name', 'fr', 'Evasion');

        $fly = new Skill();
        $fly
            ->setName('Fly')
            ->setArmorCheckPenalty(true)
            ->setKeyAbility('dexterity');
        $translationsRepository->translate($fly, 'name', 'fr', 'Vol');

        $handleAnimal = new Skill();
        $handleAnimal
            ->setName('Handle Animal')
            ->setUntrained(false)
            ->setKeyAbility('charisma');
        $translationsRepository->translate($handleAnimal, 'name', 'fr', 'Dressage');

        $heal = new Skill();
        $heal
            ->setName('Heal')
            ->setKeyAbility('wisdom');
        $translationsRepository->translate($heal, 'name', 'fr', 'Premiers secours');

        $intimidate = new Skill();
        $intimidate
            ->setName('Intimidate')
            ->setKeyAbility('charisma');
        $translationsRepository->translate($intimidate, 'name', 'fr', 'Intimidation');

        $knowledgeArcana = new Skill();
        $knowledgeArcana
            ->setName('Knowledge (Arcana)')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $translationsRepository->translate($knowledgeArcana, 'name', 'fr', 'Connaissance (Arcanes)');

        $knowledgeDungeoneering = new Skill();
        $knowledgeDungeoneering
            ->setName('Knowledge (Dungeoneering)')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $translationsRepository->translate($knowledgeDungeoneering, 'name', 'fr', 'Connaissance (Exploration)');

        $knowledgeEngineering = new Skill();
        $knowledgeEngineering
            ->setName('Knowledge (Engineering)')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $translationsRepository->translate($knowledgeEngineering, 'name', 'fr', 'Connaissance (Ingénierie)');

        $knowledgeGeography = new Skill();
        $knowledgeGeography
            ->setName('Knowledge (Geography)')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $translationsRepository->translate($knowledgeGeography, 'name', 'fr', 'Connaissance (Géographie)');

        $knowledgeHistory = new Skill();
        $knowledgeHistory
            ->setName('Knowledge (History)')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $translationsRepository->translate($knowledgeHistory, 'name', 'fr', 'Connaissance (Histoire)');

        $knowledgeLocal = new Skill();
        $knowledgeLocal
            ->setName('Knowledge (Local)')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $translationsRepository->translate($knowledgeLocal, 'name', 'fr', 'Connaissance (Folklore local)');

        $knowledgeNature = new Skill();
        $knowledgeNature
            ->setName('Knowledge (Nature)')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $translationsRepository->translate($knowledgeNature, 'name', 'fr', 'Connaissance (Nature)');

        $knowledgeNobility = new Skill();
        $knowledgeNobility
            ->setName('Knowledge (Nobility)')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $translationsRepository->translate($knowledgeNobility, 'name', 'fr', 'Connaissance (Noblesse)');

        $knowledgePlanes = new Skill();
        $knowledgePlanes
            ->setName('Knowledge (Planes)')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $translationsRepository->translate($knowledgePlanes, 'name', 'fr', 'Connaissance (Plans)');

        $knowledgeReligion = new Skill();
        $knowledgeReligion
            ->setName('Knowledge (Religion)')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $translationsRepository->translate($knowledgeReligion, 'name', 'fr', 'Connaissance (Religion)');

        $linguistics = new Skill();
        $linguistics
            ->setName('Linguistics')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $translationsRepository->translate($linguistics, 'name', 'fr', 'Linguistique');

        $perception = new Skill();
        $perception
            ->setName('Perception')
            ->setKeyAbility('wisdom');
        $translationsRepository->translate($perception, 'name', 'fr', 'Perception');

        $perform = new Skill();
        $perform
            ->setName('Perform')
            ->setKeyAbility('charisma');
        $translationsRepository->translate($perform, 'name', 'fr', 'Représentation');

        $profession = new Skill();
        $profession
            ->setName('Profession')
            ->setUntrained(false)
            ->setKeyAbility('wisdom');
        $translationsRepository->translate($profession, 'name', 'fr', 'Profession');

        $ride = new Skill();
        $ride
            ->setName('Ride')
            ->setArmorCheckPenalty(true)
            ->setKeyAbility('dexterity');
        $translationsRepository->translate($ride, 'name', 'fr', 'Equitation');

        $senseMotive = new Skill();
        $senseMotive
            ->setName('Sense Motive')
            ->setKeyAbility('wisdom');
        $translationsRepository->translate($senseMotive, 'name', 'fr', 'Psychologie');

        $sleightOfHand = new Skill();
        $sleightOfHand
            ->setName('Sleight of Hand')
            ->setUntrained(false)
            ->setKeyAbility('dexterity');
        $translationsRepository->translate($sleightOfHand, 'name', 'fr', 'Escamotage');

        $spellcraft = new Skill();
        $spellcraft
            ->setName('Spellcraft')
            ->setUntrained(false)
            ->setKeyAbility('intelligence');
        $translationsRepository->translate($spellcraft, 'name', 'fr', 'Art de la magie');

        $stealth = new Skill();
        $stealth
            ->setName('Stealth')
            ->setArmorCheckPenalty(true)
            ->setKeyAbility('dexterity');
        $translationsRepository->translate($stealth, 'name', 'fr', 'Discrétion');

        $survival = new Skill();
        $survival
            ->setName('Survival')
            ->setKeyAbility('wisdom');
        $translationsRepository->translate($survival, 'name', 'fr', 'Survie');

        $swim = new Skill();
        $swim
            ->setName('Swim')
            ->setArmorCheckPenalty(true)
            ->setKeyAbility('strength');
        $translationsRepository->translate($swim, 'name', 'fr', 'Natation');

        $useMagicDevice = new Skill();
        $useMagicDevice
            ->setName('Use Magic Device')
            ->setUntrained(false)
            ->setKeyAbility('charisma');
        $translationsRepository->translate($useMagicDevice, 'name', 'fr', "Utilisation d'objets magiques");

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
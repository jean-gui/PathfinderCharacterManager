<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troulite\PathfinderBundle\Entity\ClassDefinition;
use Troulite\PathfinderBundle\Entity\ClassPower;

/**
 * Class LoadClassDefinitionData
 *
 * @package Troulite\PathfinderBundle\DataFixtures\ORM
 */
class LoadClassDefinitionData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $bab = array();
        $reflexes = array();
        $fortitude = array();
        $will = array();
        for ($i = 0; $i < 20; $i++) {
            $bab[] = $i + 1;
            $reflexes[] = ((int)(($i + 1) / 2)) + 2;
            $fortitude[] = ((int)(($i + 1) / 2)) + 2;
            $will[] = (int)(($i + 1) / 3);
        }
        $spellsPerDay = array(
            1 => array(-1, -1, -1, 0, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 3, 4, 4, 4, 4),
            2 => array(-1, -1, -1, -1, -1, -1, 0, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 3, 4),
            3 => array(-1, -1, -1, -1, -1, -1, -1, -1, -1, 0, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3),
            4 => array(-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 0, 1, 1, 1, 1, 2, 2, 3)
        );

        $ranger = new ClassDefinition();
        $ranger
            ->setName("Ranger")
            ->setHpDice(10)
            ->setSkillPoints(6)
            ->setBab($bab)
            ->setReflexes($reflexes)
            ->setFortitude($fortitude)
            ->setWill($will)
            ->setSpellsPerDay($spellsPerDay)
            ->addClassSkill($this->getReference('climb'))
            ->addClassSkill($this->getReference('craft'))
            ->addClassSkill($this->getReference('handleAnimal'))
            ->addClassSkill($this->getReference('heal'))
            ->addClassSkill($this->getReference('intimidate'))
            ->addClassSkill($this->getReference('knowledgeDungeoneering'))
            ->addClassSkill($this->getReference('knowledgeGeography'))
            ->addClassSkill($this->getReference('knowledgeNature'))
            ->addClassSkill($this->getReference('perception'))
            ->addClassSkill($this->getReference('profession'))
            ->addClassSkill($this->getReference('ride'))
            ->addClassSkill($this->getReference('spellcraft'))
            ->addClassSkill($this->getReference('stealth'))
            ->addClassSkill($this->getReference('survival'))
            ->addClassSkill($this->getReference('swim'))
            ->setSpecials(
                array(
                    '2' => ['extra_feats' => ['type' => 'class', 'value' => '1']],
                    '6' => ['extra_feats' => ['type' => 'class', 'value' => '1']],
                    '10' => ['extra_feats' => ['type' => 'class', 'value' => '1']],
                    '15' => ['extra_feats' => ['type' => 'class', 'value' => '1']],
                    '18' => ['extra_feats' => ['type' => 'class', 'value' => '1']],
                )
            );

        $manager->persist($ranger);
        $manager->flush();

        $this->addReference('ranger', $ranger);

        $bab = array();
        $reflexes = array();
        $fortitude = array();
        $will = array();
        for ($i = 0; $i < 20; $i++) {
            $bab[] = $i + 1;
            $reflexes[] = (int)(($i + 1) / 3);
            $fortitude[] = ((int)(($i + 1) / 2)) + 2;
            $will[] = (int)(($i + 1) / 3);
        }

        $barbarian = new ClassDefinition();
        $barbarian
            ->setName("Barbarian")
            ->setHpDice(12)
            ->setSkillPoints(4)
            ->setBab($bab)
            ->setReflexes($reflexes)
            ->setFortitude($fortitude)
            ->setWill($will)
            ->addClassSkill($this->getReference('climb'))
            ->addClassSkill($this->getReference('craft'))
            ->addClassSkill($this->getReference('handleAnimal'))
            ->addClassSkill($this->getReference('acrobatics'))
            ->addClassSkill($this->getReference('intimidate'))
            ->addClassSkill($this->getReference('knowledgeNature'))
            ->addClassSkill($this->getReference('perception'))
            ->addClassSkill($this->getReference('ride'))
            ->addClassSkill($this->getReference('survival'))
            ->addClassSkill($this->getReference('swim'));

        $manager->persist($barbarian);
        $manager->flush();

        $this->addReference('barbarian', $barbarian);

        $bab       = array();
        $reflexes  = array();
        $fortitude = array();
        $will      = array();
        for ($i = 0; $i < 20; $i++) {
            $bab[]       = $i + 1;
            $reflexes[]  = ((int)(($i + 1) / 3)) ;
            $fortitude[] = ((int)(($i + 1) / 2)) + 2;
            $will[]      = (int)(($i + 1) / 2) + 2;
        }
        $spellsPerDay = array(
            1 => array(-1, -1, -1, 0, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 3, 4, 4, 4, 4),
            2 => array(-1, -1, -1, -1, -1, -1, 0, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 3, 4),
            3 => array(-1, -1, -1, -1, -1, -1, -1, -1, -1, 0, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3),
            4 => array(-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 0, 1, 1, 1, 1, 2, 2, 3)
        );

        $paladin = new ClassDefinition();
        $paladin
            ->setName("Paladin")
            ->setHpDice(10)
            ->setSkillPoints(2)
            ->setBab($bab)
            ->setReflexes($reflexes)
            ->setFortitude($fortitude)
            ->setWill($will)
            ->setSpellsPerDay($spellsPerDay)
            ->addClassSkill($this->getReference('craft'))
            ->addClassSkill($this->getReference('diplomacy'))
            ->addClassSkill($this->getReference('handleAnimal'))
            ->addClassSkill($this->getReference('heal'))
            ->addClassSkill($this->getReference('knowledgeNobility'))
            ->addClassSkill($this->getReference('knowledgeReligion'))
            ->addClassSkill($this->getReference('profession'))
            ->addClassSkill($this->getReference('ride'))
            ->addClassSkill($this->getReference('senseMotive'))
            ->addClassSkill($this->getReference('spellcraft'));
        $power = (new ClassPower())
            ->setName('Divine Grace')
            ->setDescription(
                'At 2nd level, a paladin gains a bonus equal to her Charisma bonus (if any) on all Saving Throws.'
            )
            ->setLevel(2)
            ->setClass($paladin)
            ->setPassive(true)
            ->setEffects(
                array(
                    'fortitude' => array('type' => null, 'value' => 'c.getAbilityModifier(c.getCharisma())'),
                    'reflexes'  => array('type' => null, 'value' => 'c.getAbilityModifier(c.getCharisma())'),
                    'will'      => array('type' => null, 'value' => 'c.getAbilityModifier(c.getCharisma())')
                )
            );
        $paladin->addPower($power);

        $manager->persist($power);
        $manager->persist($paladin);
        $manager->flush();

        $this->addReference('divine-grace', $power);
        $this->addReference('paladin', $paladin);

        $bab       = array(0,1,2,3,3,4,5,6,6,7,8,9,9,10,11,12,12,13,14,15);
        $reflexes  = array();
        $fortitude = array();
        $will      = array();
        for ($i = 0; $i < 20; $i++) {
            $reflexes[]  = ((int)(($i + 1) / 2)) + 2;
            $fortitude[] = ((int)(($i + 1) / 3));
            $will[]      = (int)(($i + 1) / 2) + 2;
        }
        $spellsPerDay = array(
            1 => array( 1,  2,  3,  3,  4,  4,  4,  4,  5,  5,  5,  5,  5,  5,  5, 5, 5, 5, 5, 5),
            2 => array(-1, -1, -1,  1,  2,  3,  3,  4,  4,  4,  4,  5,  5,  5,  5, 5, 5, 5, 5, 5),
            3 => array(-1, -1, -1, -1, -1, -1,  1,  2,  3,  3,  4,  4,  4,  4,  5, 5, 5, 5, 5, 5),
            4 => array(-1, -1, -1, -1, -1, -1, -1, -1, -1,  1,  2,  3,  3,  4,  4, 4, 4, 5, 5, 5),
            5 => array(-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,  1,  2,  3, 3, 4, 4, 5, 5),
            6 => array(-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 1, 2, 3, 4, 5),
        );

        $bard = new ClassDefinition();
        $bard
            ->setName("Bard")
            ->setHpDice(8)
            ->setSkillPoints(6)
            ->setBab($bab)
            ->setReflexes($reflexes)
            ->setFortitude($fortitude)
            ->setWill($will)
            ->setSpellsPerDay($spellsPerDay)
            ->addClassSkill($this->getReference('acrobatics'))
            ->addClassSkill($this->getReference('appraise'))
            ->addClassSkill($this->getReference('bluff'))
            ->addClassSkill($this->getReference('climb'))
            ->addClassSkill($this->getReference('craft'))
            ->addClassSkill($this->getReference('diplomacy'))
            ->addClassSkill($this->getReference('disguise'))
            ->addClassSkill($this->getReference('escapeArtist'))
            ->addClassSkill($this->getReference('intimidate'))
            ->addClassSkill($this->getReference('knowledgeArcana'))
            ->addClassSkill($this->getReference('knowledgeDungeoneering'))
            ->addClassSkill($this->getReference('knowledgeEngineering'))
            ->addClassSkill($this->getReference('knowledgeGeography'))
            ->addClassSkill($this->getReference('knowledgeHistory'))
            ->addClassSkill($this->getReference('knowledgeLocal'))
            ->addClassSkill($this->getReference('knowledgeNature'))
            ->addClassSkill($this->getReference('knowledgeNobility'))
            ->addClassSkill($this->getReference('knowledgePlanes'))
            ->addClassSkill($this->getReference('knowledgeReligion'))
            ->addClassSkill($this->getReference('linguistics'))
            ->addClassSkill($this->getReference('perception'))
            ->addClassSkill($this->getReference('perform'))
            ->addClassSkill($this->getReference('profession'))
            ->addClassSkill($this->getReference('senseMotive'))
            ->addClassSkill($this->getReference('sleightOfHand'))
            ->addClassSkill($this->getReference('spellcraft'))
            ->addClassSkill($this->getReference('stealth'))
            ->addClassSkill($this->getReference('useMagicDevice'));

        $manager->persist($bard);
        $manager->flush();

        $this->addReference('bard',$bard);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 2;
    }
}
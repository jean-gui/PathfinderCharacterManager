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
            ->setCastingAbility('wisdom')
            ->setPreparationNeeded(true)
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
            ->addClassSkill($this->getReference('swim'));

        $power = (new ClassPower())
            ->setName('First Favored Enemy (+2)')
            ->setLevel(1)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    'melee-attack-roll' => array('type' => 'favored-enemy', 'value' => 2),
                    'melee-damage-roll'  => array('type' => 'favored-enemy', 'value' => 2),
                    'ranged-attack-roll' => array('type' => 'favored-enemy', 'value' => 2),
                    'ranged-damage-roll' => array('type' => 'favored-enemy', 'value' => 2),
                    'bluff'      => array('type' => 'favored-enemy', 'value' => 2),
                    'perception' => array('type' => 'favored-enemy', 'value' => 2),
                    'sense-motive' => array('type' => 'favored-enemy', 'value' => 2),
                    'survival' => array('type' => 'favored-enemy', 'value' => 2),
                )
            );
        $ranger->addPower($power);
        $this->setReference('favored-enemy-1', $power);

        $power = (new ClassPower())
            ->setName('Track')
            ->setLevel(1)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    // 1 == ranger class id
                    'survival' => array('type' => null, 'value' => 'max(1, div(c.getLevel(1), 2))'),
                )
            );
        $ranger->addPower($power);
        $this->setReference('track', $power);

        $power = (new ClassPower())
            ->setName('Wild Empathy')
            ->setLevel(1)
            ->setClass($ranger)
            ->setPassive(false);
        $ranger->addPower($power);
        $this->setReference('wild-empathy', $power);

        $power = (new ClassPower())
            ->setName('First Combat Style Feat')
            ->setLevel(2)
            ->setClass($ranger)
            ->setPassive(true)
            ->setEffects(
                array('extra_feats' => ['type' => 'class', 'value' => 1])
            );
        $ranger->addPower($power);
        $this->setReference('combat-style-feat-1', $power);

        $power = (new ClassPower())
            ->setName('Endurance')
            ->setLevel(3)
            ->setClass($ranger)
            ->setPassive(true)
            ->setEffects(
                array('feat' => ['type' => null, 'value' => 'Endurance'])
            );

        $ranger->addPower($power);
        $this->setReference('endurance', $power);

        $power = (new ClassPower())
            ->setName('Favored Terrain +2')
            ->setLevel(3)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    'initiative' => array('type' => null, 'value' => 2),
                    'knowledge-geography' => array('type' => null, 'value' => 2),
                    'perception' => array('type' => null, 'value' => 2),
                    'stealth' => array('type' => null, 'value' => 2),
                    'survival' => array('type' => null, 'value' => 2),
                )
            );
        $ranger->addPower($power);
        $this->setReference('favored-terrain-1', $power);

        $power = (new ClassPower())
            ->setName("Hunter's Bond")
            ->setLevel(4)
            ->setClass($ranger)
            ->setPassive(false);
        $ranger->addPower($power);
        $this->setReference('hunter-bond', $power);

        $power = (new ClassPower())
            ->setName('Second Favored Enemy (+4)')
            ->setLevel(5)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    'melee-attack-roll'  => array('type' => 'favored-enemy', 'value' => 4),
                    'melee-damage-roll'  => array('type' => 'favored-enemy', 'value' => 4),
                    'ranged-attack-roll' => array('type' => 'favored-enemy', 'value' => 4),
                    'ranged-damage-roll' => array('type' => 'favored-enemy', 'value' => 4),
                    'bluff'              => array('type' => 'favored-enemy', 'value' => 4),
                    'perception'         => array('type' => 'favored-enemy', 'value' => 4),
                    'sense-motive'       => array('type' => 'favored-enemy', 'value' => 4),
                    'survival'           => array('type' => 'favored-enemy', 'value' => 4),
                )
            );
        $ranger->addPower($power);
        $this->setReference('favored-enemy-2', $power);

        $power = (new ClassPower())
            ->setName('Second Combat Style Feat')
            ->setLevel(6)
            ->setClass($ranger)
            ->setPassive(true)
            ->setEffects(
                array('extra_feats' => ['type' => 'class', 'value' => 1])
            );
        $ranger->addPower($power);
        $this->setReference('combat-style-feat-2', $power);

        $power = (new ClassPower())
            ->setName('Woodland Stride')
            ->setLevel(7)
            ->setClass($ranger)
            ->setPassive(true);
        $ranger->addPower($power);
        $this->setReference('woodland-stride', $power);

        $power = (new ClassPower())
            ->setName('Swift Tracker')
            ->setLevel(8)
            ->setClass($ranger)
            ->setPassive(false);
        $ranger->addPower($power);
        $this->setReference('swift-tracker', $power);

        $power = (new ClassPower())
            ->setName('Favored Terrain +4')
            ->setLevel(8)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    'initiative'          => array('type' => null, 'value' => 4),
                    'knowledge-geography' => array('type' => null, 'value' => 4),
                    'perception'          => array('type' => null, 'value' => 4),
                    'stealth'             => array('type' => null, 'value' => 4),
                    'survival'            => array('type' => null, 'value' => 4),
                )
            );
        $ranger->addPower($power);
        $this->setReference('favored-terrain-2', $power);

        $power = (new ClassPower())
            ->setName('Evasion')
            ->setLevel(9)
            ->setClass($ranger)
            ->setPassive(true);
        $ranger->addPower($power);
        $this->setReference('evasion', $power);

        $power = (new ClassPower())
            ->setName('Third Combat Style Feat')
            ->setLevel(10)
            ->setClass($ranger)
            ->setPassive(true)
            ->setEffects(
                array('extra_feats' => ['type' => 'class', 'value' => 1])
            );
        $ranger->addPower($power);
        $this->setReference('combat-style-feat-3', $power);

        $power = (new ClassPower())
            ->setName('Third Favored Enemy (+6)')
            ->setLevel(10)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    'melee-attack-roll'  => array('type' => 'favored-enemy', 'value' => 6),
                    'melee-damage-roll'  => array('type' => 'favored-enemy', 'value' => 6),
                    'ranged-attack-roll' => array('type' => 'favored-enemy', 'value' => 6),
                    'ranged-damage-roll' => array('type' => 'favored-enemy', 'value' => 6),
                    'bluff'              => array('type' => 'favored-enemy', 'value' => 6),
                    'perception'         => array('type' => 'favored-enemy', 'value' => 6),
                    'sense-motive'       => array('type' => 'favored-enemy', 'value' => 6),
                    'survival'           => array('type' => 'favored-enemy', 'value' => 6),
                )
            );
        $ranger->addPower($power);
        $this->setReference('favored-enemy-3', $power);

        $power = (new ClassPower())
            ->setName('Quarry')
            ->setLevel(11)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    'ranged-attack-roll' => array('type' => null, 'value' => 2),
                    'melee-attack-roll'  => array('type' => null, 'value' => 2),
                )
            );
        $ranger->addPower($power);
        $this->setReference('quarry', $power);

        $power = (new ClassPower())
            ->setName('Camouflage')
            ->setLevel(12)
            ->setClass($ranger)
            ->setPassive(true);
        $ranger->addPower($power);
        $this->setReference('camouflage', $power);

        $power = (new ClassPower())
            ->setName('Favored Terrain +6')
            ->setLevel(13)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    'initiative'          => array('type' => null, 'value' => 6),
                    'knowledge-geography' => array('type' => null, 'value' => 6),
                    'perception'          => array('type' => null, 'value' => 6),
                    'stealth'             => array('type' => null, 'value' => 6),
                    'survival'            => array('type' => null, 'value' => 6),
                )
            );
        $ranger->addPower($power);
        $this->setReference('favored-terrain-3', $power);

        $power = (new ClassPower())
            ->setName('Fourth Combat Style Feat')
            ->setLevel(14)
            ->setClass($ranger)
            ->setPassive(true)
            ->setEffects(
                array('extra_feats' => ['type' => 'class', 'value' => 1])
            );
        $ranger->addPower($power);
        $this->setReference('combat-style-feat-4', $power);

        $power = (new ClassPower())
            ->setName('Fourth Favored Enemy (+8)')
            ->setLevel(15)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    'melee-attack-roll'  => array('type' => 'favored-enemy', 'value' => 8),
                    'melee-damage-roll'  => array('type' => 'favored-enemy', 'value' => 8),
                    'ranged-attack-roll' => array('type' => 'favored-enemy', 'value' => 8),
                    'ranged-damage-roll' => array('type' => 'favored-enemy', 'value' => 8),
                    'bluff'              => array('type' => 'favored-enemy', 'value' => 8),
                    'perception'         => array('type' => 'favored-enemy', 'value' => 8),
                    'sense-motive'       => array('type' => 'favored-enemy', 'value' => 8),
                    'survival'           => array('type' => 'favored-enemy', 'value' => 8),
                )
            );
        $ranger->addPower($power);
        $this->setReference('favored-enemy-4', $power);

        $power = (new ClassPower())
            ->setName('Improved Evasion')
            ->setLevel(16)
            ->setClass($ranger)
            ->setPassive(true);
        $ranger->addPower($power);
        $this->setReference('improved-evasion', $power);

        $power = (new ClassPower())
            ->setName('Hide in Plain Sight')
            ->setLevel(17)
            ->setClass($ranger)
            ->setPassive(false);
        $ranger->addPower($power);
        $this->setReference('hide-in-plain-sight', $power);

        $power = (new ClassPower())
            ->setName('Fifth Combat Style Feat')
            ->setLevel(18)
            ->setClass($ranger)
            ->setPassive(true)
            ->setEffects(
                array('extra_feats' => ['type' => 'class', 'value' => 1])
            );
        $ranger->addPower($power);
        $this->setReference('combat-style-feat-5', $power);

        $power = (new ClassPower())
            ->setName('Favored Terrain +8')
            ->setLevel(18)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    'initiative'          => array('type' => null, 'value' => 8),
                    'knowledge-geography' => array('type' => null, 'value' => 8),
                    'perception'          => array('type' => null, 'value' => 8),
                    'stealth'             => array('type' => null, 'value' => 8),
                    'survival'            => array('type' => null, 'value' => 8),
                )
            );
        $ranger->addPower($power);
        $this->setReference('favored-terrain-4', $power);

        $power = (new ClassPower())
            ->setName('Improved Quarry')
            ->setLevel(19)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    'ranged-attack-roll' => array('type' => null, 'value' => 4),
                    'melee-attack-roll'  => array('type' => null, 'value' => 4),
                )
            );
        $ranger->addPower($power);
        $this->setReference('improved-quarry', $power);

        $power = (new ClassPower())
            ->setName('Master Hunter')
            ->setLevel(20)
            ->setClass($ranger)
            ->setPassive(false);
        $ranger->addPower($power);
        $this->setReference('master-hunter', $power);

        /**
         * @todo Missing knowledge bonus
         */
        $power = (new ClassPower())
            ->setName('Fifth Favored Enemy (+10)')
            ->setLevel(20)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    'melee-attack-roll'  => array('type' => 'favored-enemy', 'value' => 10),
                    'melee-damage-roll'  => array('type' => 'favored-enemy', 'value' => 10),
                    'ranged-attack-roll' => array('type' => 'favored-enemy', 'value' => 10),
                    'ranged-damage-roll' => array('type' => 'favored-enemy', 'value' => 10),
                    'bluff'              => array('type' => 'favored-enemy', 'value' => 10),
                    'perception'         => array('type' => 'favored-enemy', 'value' => 10),
                    'sense-motive'       => array('type' => 'favored-enemy', 'value' => 10),
                    'survival'           => array('type' => 'favored-enemy', 'value' => 10),
                )
            );
        $ranger->addPower($power);
        $this->setReference('favored-enemy-4', $power);

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

        $power = (new ClassPower())
            ->setName('Fast Movement')
            ->setLevel(1)
            ->setClass($barbarian)
            ->setPassive(true);
        $barbarian->addPower($power);
        $this->addReference('fast-movement', $power);

        $power = (new ClassPower())
            ->setName('Rage')
            ->setLevel(1)
            ->setClass($barbarian)
            ->setPassive(false)
            ->setEffects(
                array(
                    'strength' => ['type' => 'morale', 'value' => 4],
                    'constitution' => ['type' => 'morale', 'value' => 4],
                    'will' => ['type' => 'morale', 'value' => 2],
                    'ac' => ['type' => null, 'value' => -2],
                )
            );
        $barbarian->addPower($power);
        $this->addReference('rage', $power);

        $power = (new ClassPower())
            ->setName('Uncanny Dodge')
            ->setLevel(2)
            ->setClass($barbarian)
            ->setPassive(true);
        $barbarian->addPower($power);
        $this->addReference('uncanny-dodge', $power);

        $power = (new ClassPower())
            ->setName('Trap Sense')
            ->setLevel(3)
            ->setClass($barbarian)
            ->setPassive(true);
        $barbarian->addPower($power);
        $this->addReference('trap-sense', $power);

        $power = (new ClassPower())
            ->setName('Improved Uncanny Dodge')
            ->setLevel(5)
            ->setClass($barbarian)
            ->setPassive(true);
        $barbarian->addPower($power);
        $this->addReference('improved-uncanny-dodge', $power);

        $power = (new ClassPower())
            ->setName('Damage Reduction')
            ->setLevel(7)
            ->setClass($barbarian)
            ->setPassive(true)
            ->setEffects(
                array(
                    'damage-reduction' => ['type' => null, 'value' => 'div(c.getLevel(2), 3) - 1']
                )
            );
        $barbarian->addPower($power);
        $this->addReference('damage-reduction', $power);

        $power = (new ClassPower())
            ->setName('Greater Rage')
            ->setLevel(11)
            ->setClass($barbarian)
            ->setPassive(true)
            ->setEffects(
                array(
                    'strength' => ['type' => 'morale', 'value' => 6],
                    'constitution' => ['type' => 'morale', 'value' => 6],
                    'will' => ['type' => 'morale', 'value' => 3],
                )
            )
            ->setExternalConditions(
                array('active-power' => 'rage')
            );
        $barbarian->addPower($power);
        $this->addReference('Greater Rage', $power);

        $power = (new ClassPower())
            ->setName('Indomitable Will')
            ->setLevel(14)
            ->setClass($barbarian)
            ->setPassive(true)
            ->setEffects(
                array(
                    'saving-enchantment' => ['type' => null, 'value' => 4]
                )
            )
            ->setExternalConditions(
                array('active-power' => 'rage')
            );
        $barbarian->addPower($power);
        $this->addReference('indomitable-will', $power);

        $power = (new ClassPower())
            ->setName('Tireless Rage')
            ->setLevel(17)
            ->setClass($barbarian)
            ->setPassive(true)
            ->setExternalConditions(
                array('active-power' => 'rage')
            );
        $barbarian->addPower($power);
        $this->addReference('tireless-rage', $power);

        $power = (new ClassPower())
            ->setName('Mighty Rage')
            ->setLevel(20)
            ->setClass($barbarian)
            ->setPassive(false)
            ->setEffects(
                array(
                    'strength'     => ['type' => 'morale', 'value' => 8],
                    'constitution' => ['type' => 'morale', 'value' => 8],
                    'will'         => ['type' => 'morale', 'value' => 4],
                )
            )
            ->setExternalConditions(
                array('active-power' => 'rage')
            );
        $barbarian->addPower($power);
        $this->addReference('mighty-rage', $power);

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
            ->setCastingAbility('charisma')
            ->setPreparationNeeded(true)
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
            ->setName('Aura of Good')
            ->setLevel(1)
            ->setClass($paladin)
            ->setPassive(false);
        $paladin->addPower($power);
        $this->addReference('aura-of-good', $power);

        $power = (new ClassPower())
            ->setName('Detect Evil')
            ->setLevel(1)
            ->setClass($paladin)
            ->setPassive(false);
        $paladin->addPower($power);
        $this->addReference('detect-evil', $power);

        $power = (new ClassPower())
            ->setName('Smite Evil')
            ->setLevel(1)
            ->setClass($paladin)
            ->setPassive(false)
            ->setEffects(
                array(
                    'melee-attack-roll' => [
                        'type' => null,
                        'value' => 'max(0, c.getAbilityModifier(c.getCharisma()))'
                    ],
                    'ranged-attack-roll' => [
                        'type' => null,
                        'value' => 'max(0, c.getAbilityModifier(c.getCharisma()))'
                    ],
                    'melee-damage-roll' => ['type' => null, 'value' => 'c.getLevel(3)'],
                    'ranged-damage-roll' => ['type' => null, 'value' => 'c.getLevel(3)'],
                    'ac' => ['type' => 'deflection', 'value' => 'max(0, c.getAbilityModifier(c.getCharisma()))']
                )
            );
        $paladin->addPower($power);
        $this->addReference('smite-evil', $power);

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
                    'fortitude' => array('type' => null, 'value' => 'max(0, c.getAbilityModifier(c.getCharisma()))'),
                    'reflexes'  => array('type' => null, 'value' => 'max(0, c.getAbilityModifier(c.getCharisma()))'),
                    'will'      => array('type' => null, 'value' => 'max(0, c.getAbilityModifier(c.getCharisma()))')
                )
            );
        $paladin->addPower($power);
        $this->addReference('divine-grace', $power);

        $power = (new ClassPower())
            ->setName('Lay On Hands')
            ->setLevel(2)
            ->setClass($paladin)
            ->setPassive(false);
        $paladin->addPower($power);
        $this->addReference('lay-on-hands', $power);

        $power = (new ClassPower())
            ->setName('Aura of Courage')
            ->setLevel(3)
            ->setClass($paladin)
            ->setPassive(true);
        $paladin->addPower($power);
        $this->addReference('aura-of-courage', $power);

        $power = (new ClassPower())
            ->setName('Divine Health')
            ->setLevel(3)
            ->setClass($paladin)
            ->setPassive(false);
        $paladin->addPower($power);
        $this->addReference('divine-health', $power);

        $power = (new ClassPower())
            ->setName('First Mercy')
            ->setLevel(3)
            ->setClass($paladin)
            ->setPassive(true);
        $paladin->addPower($power);
        $this->addReference('mercy-1', $power);

        $power = (new ClassPower())
            ->setName('Channel Positive Energy')
            ->setLevel(4)
            ->setClass($paladin)
            ->setPassive(false);
        $paladin->addPower($power);
        $this->addReference('channel-positive-energy', $power);

        $power = (new ClassPower())
            ->setName('Divine Bond')
            ->setLevel(5)
            ->setClass($paladin)
            ->setPassive(false);
        $paladin->addPower($power);
        $this->addReference('divine-bond', $power);

        $power = (new ClassPower())
            ->setName('Second Mercy')
            ->setLevel(6)
            ->setClass($paladin)
            ->setPassive(true);
        $paladin->addPower($power);
        $this->addReference('mercy-2', $power);

        $power = (new ClassPower())
            ->setName('Aura of Resolve')
            ->setLevel(8)
            ->setClass($paladin)
            ->setPassive(true);
        $paladin->addPower($power);
        $this->addReference('aura-of-resolve', $power);

        $power = (new ClassPower())
            ->setName('Third Mercy')
            ->setLevel(9)
            ->setClass($paladin)
            ->setPassive(true);
        $paladin->addPower($power);
        $this->addReference('mercy-3', $power);

        $power = (new ClassPower())
            ->setName('Aura of Justice')
            ->setLevel(11)
            ->setClass($paladin)
            ->setPassive(false);
        $paladin->addPower($power);
        $this->addReference('aura-of-justice', $power);

        $power = (new ClassPower())
            ->setName('Fourth Mercy')
            ->setLevel(12)
            ->setClass($paladin)
            ->setPassive(true);
        $paladin->addPower($power);
        $this->addReference('mercy-4', $power);

        $power = (new ClassPower())
            ->setName('Aura of Faith')
            ->setLevel(14)
            ->setClass($paladin)
            ->setPassive(true);
        $paladin->addPower($power);
        $this->addReference('aura-of-faith', $power);

        $power = (new ClassPower())
            ->setName('Fifth Mercy')
            ->setLevel(15)
            ->setClass($paladin)
            ->setPassive(true);
        $paladin->addPower($power);
        $this->addReference('mercy-5', $power);

        $power = (new ClassPower())
            ->setName('Aura of Righteousness')
            ->setLevel(17)
            ->setClass($paladin)
            ->setPassive(true);
        $paladin->addPower($power);
        $this->addReference('aura-of-righteousness', $power);

        $power = (new ClassPower())
            ->setName('Sixth Mercy')
            ->setLevel(18)
            ->setClass($paladin)
            ->setPassive(true);
        $paladin->addPower($power);
        $this->addReference('mercy-6', $power);

        $power = (new ClassPower())
            ->setName('Holy Champion')
            ->setLevel(20)
            ->setClass($paladin)
            ->setPassive(false);
        $paladin->addPower($power);
        $this->addReference('holy-champion', $power);

        $manager->persist($paladin);
        $manager->flush();
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
        $knownSpellsPerLevel = array(
            0 => array(4, 5, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6),
            1 => array(2, 3, 4, 4, 4, 4, 5, 5, 5, 5, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6),
            2 => array(0, 0, 0, 2, 3, 4, 4, 4, 4, 5, 5, 5, 5, 6, 6, 6, 6, 6, 6, 6),
            3 => array(0, 0, 0, 0, 0, 0, 2, 3, 4, 4, 4, 4, 5, 5, 5, 5, 6, 6, 6, 6),
            4 => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 3, 4, 4, 4, 4, 5, 5, 5, 5, 6),
            5 => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 3, 4, 4, 4, 4, 5, 5),
            6 => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 3, 4, 4, 5)
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
            ->setCastingAbility('charisma')
            ->setPreparationNeeded(false)
            ->setKnownSpellsPerLevel($knownSpellsPerLevel)
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

        $power = (new ClassPower())
            ->setName('Bardic Knowledge')
            ->setLevel(1)
            ->setClass($bard)
            ->setPassive(true)
            ->setEffects(
                array(
                    'knowledge-arcana' => ['type' => 'class', 'value' => 2],
                    'knowledge-dungeoneering' => ['type' => 'class', 'value' => 2],
                    'knowledge-geography' => ['type' => 'class', 'value' => 2],
                    'knowledge-history' => ['type' => 'class', 'value' => 2],
                    'knowledge-local' => ['type' => 'class', 'value' => 2],
                    'knowledge-nature' => ['type' => 'class', 'value' => 2],
                    'knwoledge-nobility' => ['type' => 'class', 'value' => 2],
                    'knowledge-planes' => ['type' => 'class', 'value' => 2],
                    'knowledge-religion' => ['type' => 'class', 'value' => 2]
                )
            );
        $bard->addPower($power);
        $this->addReference('bardic-knowledge', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Countersong')
            ->setLevel(1)
            ->setClass($bard)
            ->setPassive(false);
        $bard->addPower($power);
        $this->addReference('bardic-performance-countersong', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Distraction')
            ->setLevel(1)
            ->setClass($bard)
            ->setPassive(false);
        $bard->addPower($power);
        $this->addReference('bardic-performance-distraction', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Fascinate')
            ->setLevel(1)
            ->setClass($bard)
            ->setPassive(false);
        $bard->addPower($power);
        $this->addReference('bardic-performance - Fascinate', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Inspire Courage')
            ->setLevel(1)
            ->setClass($bard)
            ->setPassive(false)
            ->setEffects(
                array(
                    'melee-attack-roll' => [
                        'type' => 'competence',
                        'value' => '1 + (c.getLevel(4) >= 17 ? 3 : (c.getLevel(4) >= 11 ? 2 : (c.getLevel(4) >= 5 ? 1)))'
                    ],
                    'ranged-attack-roll' => [
                        'type' => 'competence',
                        'value' => '1 + (c.getLevel(4) >= 17 ? 3 : (c.getLevel(4) >= 11 ? 2 : (c.getLevel(4) >= 5 ? 1)))'
                    ],
                    'melee-damage-roll' => [
                        'type' => 'competence',
                        'value' => '1 + (c.getLevel(4) >= 17 ? 3 : (c.getLevel(4) >= 11 ? 2 : (c.getLevel(4) >= 5 ? 1)))'
                    ],
                    'ranged-damage-roll' => [
                        'type' => 'competence',
                        'value' => '1 + (c.getLevel(4) >= 17 ? 3 : (c.getLevel(4) >= 11 ? 2 : (c.getLevel(4) >= 5 ? 1)))'
                    ],
                    'saving-charm' => [
                        'type'    => 'morale',
                        'value'   => '1 + (c.getLevel(4) >= 17 ? 3 : (c.getLevel(4) >= 11 ? 2 : (c.getLevel(4) >= 5 ? 1)))'
                    ],
                    'saving-fear' => [
                        'type'    => 'competence',
                        'value'   => '1 + (c.getLevel(4) >= 17 ? 3 : (c.getLevel(4) >= 11 ? 2 : (c.getLevel(4) >= 5 ? 1)))'
                    ],
                )
            );
        $bard->addPower($power);
        $this->addReference('bardic-performance-inspire-courage', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Inspire Competence')
            ->setLevel(3)
            ->setClass($bard)
            ->setPassive(false)
            ->setEffects(
                array(
                    'skills' => ['type' => 'competence', 'value' => '2 + div(c.getLevel(4) - 3, 4)']
                )
            );
        $bard->addPower($power);
        $this->addReference('bardic-performance-inspire-competence', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Suggestion')
            ->setLevel(6)
            ->setClass($bard)
            ->setPassive(false);
        $bard->addPower($power);
        $this->addReference('bardic-performance-suggestion', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Dirge of Doom')
            ->setLevel(8)
            ->setClass($bard)
            ->setPassive(false);
        $bard->addPower($power);
        $this->addReference('bardic-performance-dirge-of-doom', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Inspire Greatness')
            ->setLevel(9)
            ->setClass($bard)
            ->setPassive(false);
        $bard->addPower($power);
        $this->addReference('bardic-performance-inspire-greatness', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Soothing Performance')
            ->setLevel(12)
            ->setClass($bard)
            ->setPassive(false);
        $bard->addPower($power);
        $this->addReference('bardic-performance-soothing-performance', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Frightening Tune')
            ->setLevel(14)
            ->setClass($bard)
            ->setPassive(false);
        $bard->addPower($power);
        $this->addReference('bardic-performance-frightening-tune', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Inspire Heroics')
            ->setLevel(15)
            ->setClass($bard)
            ->setPassive(false);
        $bard->addPower($power);
        $this->addReference('bardic-performance-inspire-heroics', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Mass Suggestion')
            ->setLevel(18)
            ->setClass($bard)
            ->setPassive(false);
        $bard->addPower($power);
        $this->addReference('bardic-performance-mass-suggestion', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Deadly Performance')
            ->setLevel(20)
            ->setClass($bard)
            ->setPassive(false);
        $bard->addPower($power);
        $this->addReference('bardic-performance-deadly-performance', $power);

        $power = (new ClassPower())
            ->setName('First Versatile Performance')
            ->setLevel(2)
            ->setClass($bard)
            ->setPassive(true);
        $bard->addPower($power);
        $this->addReference('versatile-performance-1', $power);

        $power = (new ClassPower())
            ->setName('Second Versatile Performance')
            ->setLevel(6)
            ->setClass($bard)
            ->setPassive(true);
        $bard->addPower($power);
        $this->addReference('versatile-performance-2', $power);

        $power = (new ClassPower())
            ->setName('Third Versatile Performance')
            ->setLevel(10)
            ->setClass($bard)
            ->setPassive(true);
        $bard->addPower($power);
        $this->addReference('versatile-performance-3', $power);

        $power = (new ClassPower())
            ->setName('Fourth Versatile Performance')
            ->setLevel(14)
            ->setClass($bard)
            ->setPassive(true);
        $bard->addPower($power);
        $this->addReference('versatile-performance-4', $power);

        $power = (new ClassPower())
            ->setName('Fifth Versatile Performance')
            ->setLevel(18)
            ->setClass($bard)
            ->setPassive(true);
        $bard->addPower($power);
        $this->addReference('versatile-performance-5', $power);

        $power = (new ClassPower())
            ->setName('Well Versed')
            ->setLevel(2)
            ->setClass($bard)
            ->setPassive(true)
            ->setEffects(
                array(
                    'saving-bardic' => ['type' => 'class', 'value' => 4],
                    'saving-sonic' => ['type' => 'class', 'value' => 4],
                    'saving-language' => ['type' => 'class', 'value' => 4],
                )
            );
        $bard->addPower($power);
        $this->addReference('well-versed', $power);

        $power = (new ClassPower())
            ->setName('Lore Master')
            ->setLevel(5)
            ->setClass($bard)
            ->setPassive(false);
        $bard->addPower($power);
        $this->addReference('lore-master', $power);

        $power = (new ClassPower())
            ->setName('Jack of All Trades')
            ->setLevel(5)
            ->setClass($bard)
            ->setPassive(false);
        $bard->addPower($power);
        $this->addReference('jack-of-all-trades', $power);

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
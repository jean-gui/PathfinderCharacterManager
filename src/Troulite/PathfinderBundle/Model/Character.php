<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 06/07/14
 * Time: 19:04
 */

namespace Troulite\PathfinderBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Troulite\PathfinderBundle\Entity\Abilities;
use Troulite\PathfinderBundle\Entity\BaseCharacter;
use Troulite\PathfinderBundle\Entity\Level;
use Troulite\PathfinderBundle\Entity\Skill;

/**
 * Class BaseCharacter
 *
 * @package Troulite\PathfinderBundle\Model
 */
class Character
{
    /**
     * @var BaseCharacter
     */
    private $baseCharacter;

    /**
     * @var int
     */
    private $fortitudeBonus = 0;
    /**
     * @var int
     */
    private $reflexesBonus = 0;
    /**
     * @var int
     */
    private $willBonus = 0;
    /**
     * @var int
     */
    private $rangedAttackRollsBonus = 0;
    /**
     * @var int
     */
    private $meleeAttackRollsBonus = 0;
    /**
     * @var int
     */
    private $rangedAttacksBonus = 0;
    /**
     * @var int
     */
    private $meleeAttacksBonus = 0;
    /**
     * @var int
     */
    private $rangedDamageBonus = 0;
    /**
     * @var int
     */
    private $meleeDamageBonus = 0;
    /**
     * @var int
     */
    private $hpBonus = 0;
    /**
     * @var int
     */
    private $initiativeBonus = 0;
    /**
     * @var int
     */
    private $acBonus = 0;
    /**
     * @var int
     */
    private $spellResitanceBonus = 0;
    /**
     * @var int
     */
    private $cmbBonus = 0;
    /**
     * @var int
     */
    private $cmdBonus = 0;
    /**
     * @var array
     */
    private $skillsBonuses = array();

    /**
     * @param BaseCharacter $baseCharacter
     */
    public function __construct(BaseCharacter $baseCharacter)
    {
        $this->baseCharacter = $baseCharacter;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->baseCharacter->__toString();
    }

    /**
     * @param int $acBonus
     */
    public function setAcBonus($acBonus)
    {
        $this->acBonus = $acBonus;
    }

    /**
     * @return int
     */
    public function getAcBonus()
    {
        return $this->acBonus;
    }

    /**
     * @param BaseCharacter $baseCharacter
     */
    public function setBaseCharacter($baseCharacter)
    {
        $this->baseCharacter = $baseCharacter;
    }

    /**
     * @return BaseCharacter
     */
    public function getBaseCharacter()
    {
        return $this->baseCharacter;
    }

    /**
     * @param int $cmbBonus
     */
    public function setCmbBonus($cmbBonus)
    {
        $this->cmbBonus = $cmbBonus;
    }

    /**
     * @return int
     */
    public function getCmbBonus()
    {
        return $this->cmbBonus;
    }

    /**
     * @param int $cmdBonus
     */
    public function setCmdBonus($cmdBonus)
    {
        $this->cmdBonus = $cmdBonus;
    }

    /**
     * @return int
     */
    public function getCmdBonus()
    {
        return $this->cmdBonus;
    }

    /**
     * @param int $fortitudeBonus
     */
    public function setFortitudeBonus($fortitudeBonus)
    {
        $this->fortitudeBonus = $fortitudeBonus;
    }

    /**
     * @return int
     */
    public function getFortitudeBonus()
    {
        return $this->fortitudeBonus;
    }

    /**
     * @param int $hpBonus
     */
    public function setHpBonus($hpBonus)
    {
        $this->hpBonus = $hpBonus;
    }

    /**
     * @return int
     */
    public function getHpBonus()
    {
        return $this->hpBonus;
    }

    /**
     * @param int $initiativeBonus
     */
    public function setInitiativeBonus($initiativeBonus)
    {
        $this->initiativeBonus = $initiativeBonus;
    }

    /**
     * @return int
     */
    public function getInitiativeBonus()
    {
        return $this->initiativeBonus;
    }

    /**
     * @param int $meleeAttackRollsBonus
     */
    public function setMeleeAttackRollsBonus($meleeAttackRollsBonus)
    {
        $this->meleeAttackRollsBonus = $meleeAttackRollsBonus;
    }

    /**
     * @return int
     */
    public function getMeleeAttackRollsBonus()
    {
        return $this->meleeAttackRollsBonus;
    }

    /**
     * @param int $meleeAttacksBonus
     */
    public function setMeleeAttacksBonus($meleeAttacksBonus)
    {
        $this->meleeAttacksBonus = $meleeAttacksBonus;
    }

    /**
     * @return int
     */
    public function getMeleeAttacksBonus()
    {
        return $this->meleeAttacksBonus;
    }

    /**
     * @param int $meleeDamageBonus
     * @todo one bonus per attack?
     */
    public function setMeleeDamageBonus($meleeDamageBonus)
    {
        $this->meleeDamageBonus = $meleeDamageBonus;
    }

    /**
     * @return int
     */
    public function getMeleeDamageBonus()
    {
        return $this->meleeDamageBonus;
    }

    /**
     * @param int $rangedAttackRollsBonus
     * @todo one bonus per attack?
     */
    public function setRangedAttackRollsBonus($rangedAttackRollsBonus)
    {
        $this->rangedAttackRollsBonus = $rangedAttackRollsBonus;
    }

    /**
     * @return int
     */
    public function getRangedAttackRollsBonus()
    {
        return $this->rangedAttackRollsBonus;
    }

    /**
     * @param int $rangedAttacksBonus
     */
    public function setRangedAttacksBonus($rangedAttacksBonus)
    {
        $this->rangedAttacksBonus = $rangedAttacksBonus;
    }

    /**
     * @return int
     */
    public function getRangedAttacksBonus()
    {
        return $this->rangedAttacksBonus;
    }

    /**
     * @param int $rangedDamageBonus
     */
    public function setRangedDamageBonus($rangedDamageBonus)
    {
        $this->rangedDamageBonus = $rangedDamageBonus;
    }

    /**
     * @return int
     */
    public function getRangedDamageBonus()
    {
        return $this->rangedDamageBonus;
    }

    /**
     * @param int $reflexesBonus
     */
    public function setReflexesBonus($reflexesBonus)
    {
        $this->reflexesBonus = $reflexesBonus;
    }

    /**
     * @return int
     */
    public function getReflexesBonus()
    {
        return $this->reflexesBonus;
    }

    /**
     * @param array $skillsBonuses
     */
    public function setSkillsBonuses($skillsBonuses)
    {
        $this->skillsBonuses = $skillsBonuses;
    }

    /**
     * @return array
     */
    public function getSkillsBonuses()
    {
        return $this->skillsBonuses;
    }

    /**
     * @param int $spellResitanceBonus
     */
    public function setSpellResitanceBonus($spellResitanceBonus)
    {
        $this->spellResitanceBonus = $spellResitanceBonus;
    }

    /**
     * @return int
     */
    public function getSpellResitanceBonus()
    {
        return $this->spellResitanceBonus;
    }

    /**
     * @param int $willBonus
     */
    public function setWillBonus($willBonus)
    {
        $this->willBonus = $willBonus;
    }

    /**
     * @return int
     */
    public function getWillBonus()
    {
        return $this->willBonus;
    }

    /**
     * @param Skill $skill
     *
     * @return int
     */
    public function getSkillRank(Skill $skill)
    {
        $rank = 0;
        foreach ($this->baseCharacter->getLevels() as $level) {
            foreach ($level->getSkills() as $levelSkill) {
                if ($levelSkill->getSkill() === $skill) {
                    $rank += $levelSkill->getValue();
                    break;
                }
            }
        }

        return $rank;
    }

    /**
     * @param Skill $skill
     *
     * @return bool
     */
    public function hasClassBonus(Skill $skill)
    {
        foreach ($this->baseCharacter->getLevels() as $level) {
            if ($level->getClassDefinition()->getClassSkills()->contains($skill)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public function getRangedAttackRoll()
    {
        return $this->getAttackRoll("ranged", $this->getAbilityModifier($this->getDexterity()));
    }

    /**
     * @return int
     */
    public function getMeleeDamageRoll()
    {
        return $this->getMeleeDamageBonus() + $this->getAbilityModifier($this->getStrength());
    }

    /**
     * @return int
     */
    public function getRangedDamageRoll()
    {
        return $this->getRangedDamageBonus();
    }

    /**
     * Get strength
     *
     * @return integer
     */
    public function getStrength()
    {
        $racialBonus = 0;
        if (array_key_exists("strength", $this->baseCharacter->getRace()->getModifiers())) {
            $racialBonus = $this->baseCharacter->getRace()->getModifiers()["strength"];
        }
        $levelBonus = 0;
        foreach ($this->baseCharacter->getLevels() as $level) {
            if ($level->getExtraAbility() == Abilities::STRENGTH) {
                $levelBonus += 1;
            }
        }

        return $this->baseCharacter->getAbilities()->getBaseStrength() + $racialBonus + $levelBonus;
    }

    /**
     * Get dexterity
     *
     * @return integer
     */
    public function getDexterity()
    {
        $racialBonus = 0;
        if (array_key_exists("dexterity", $this->baseCharacter->getRace()->getModifiers())) {
            $racialBonus = $this->baseCharacter->getRace()->getModifiers()["dexterity"];
        }
        $levelBonus = 0;
        foreach ($this->baseCharacter->getLevels() as $level) {
            if ($level->getExtraAbility() == Abilities::DEXTERITY) {
                $levelBonus += 1;
            }
        }

        return $this->baseCharacter->getAbilities()->getBaseDexterity() + $racialBonus + $levelBonus;
    }

    /**
     * Get constitution
     *
     * @return integer
     */
    public function getConstitution()
    {
        $racialBonus = 0;
        if (array_key_exists("constitution", $this->baseCharacter->getRace()->getModifiers())) {
            $racialBonus = $this->baseCharacter->getRace()->getModifiers()["constitution"];
        }
        $levelBonus = 0;
        foreach ($this->baseCharacter->getLevels() as $level) {
            if ($level->getExtraAbility() == Abilities::CONSTITUTION) {
                $levelBonus += 1;
            }
        }

        return $this->baseCharacter->getAbilities()->getBaseConstitution() + $racialBonus + $levelBonus;
    }

    /**
     * Get intelligence
     *
     * @return integer
     */
    public function getIntelligence()
    {
        $racialBonus = 0;
        if (array_key_exists("intelligence", $this->baseCharacter->getRace()->getModifiers())) {
            $racialBonus = $this->baseCharacter->getRace()->getModifiers()["intelligence"];
        }
        $levelBonus = 0;
        foreach ($this->baseCharacter->getLevels() as $level) {
            if ($level->getExtraAbility() == Abilities::INTELLIGENCE) {
                $levelBonus += 1;
            }
        }

        return $this->baseCharacter->getAbilities()->getBaseIntelligence() + $racialBonus + $levelBonus;
    }

    /**
     * Get wisdom
     *
     * @return integer
     */
    public function getWisdom()
    {
        $racialBonus = 0;
        if (array_key_exists("wisdom", $this->baseCharacter->getRace()->getModifiers())) {
            $racialBonus = $this->baseCharacter->getRace()->getModifiers()["wisdom"];
        }
        $levelBonus = 0;
        foreach ($this->baseCharacter->getLevels() as $level) {
            if ($level->getExtraAbility() == Abilities::WISDOM) {
                $levelBonus += 1;
            }
        }

        return $this->baseCharacter->getAbilities()->getBaseWisdom() + $racialBonus + $levelBonus;
    }

    /**
     * Get charisma
     *
     * @return integer
     */
    public function getCharisma()
    {
        $racialBonus = 0;
        if (array_key_exists("charisma", $this->baseCharacter->getRace()->getModifiers())) {
            $racialBonus = $this->baseCharacter->getRace()->getModifiers()["charisma"];
        }
        $levelBonus = 0;
        foreach ($this->baseCharacter->getLevels() as $level) {
            if ($level->getExtraAbility() == Abilities::CHARISMA) {
                $levelBonus += 1;
            }
        }

        return $this->baseCharacter->getAbilities()->getBaseCharisma() + $racialBonus + $levelBonus;
    }

    /**
     * @return array
     */
    public function getMeleeAttackRoll()
    {
        return $this->getAttackRoll("melee", $this->getAbilityModifier($this->getStrength()));
    }

    /**
     * @param $type
     * @param $modifier
     *
     * @return array
     */
    private function getAttackRoll($type, $modifier)
    {
        $bab          = $this->getBab();
        $ar           = $bab + $modifier;
        $bonusAttacks = 0;
        $ars          = array();

        switch ($type) {
            case 'ranged':
                $ar += $this->getRangedAttackRollsBonus();
                $bonusAttacks = $this->getRangedAttacksBonus();
                break;
            case 'melee':
                $ar += $this->getMeleeAttackRollsBonus();
                $bonusAttacks = $this->getMeleeAttacksBonus();
        }

        /** @noinspection PhpExpressionResultUnusedInspection */
        for ($bonusAttacks; $bonusAttacks > 0; $bonusAttacks--) {
            $ars[] = $ar;
        }
        /** @noinspection PhpExpressionResultUnusedInspection */
        for ($bab; $bab >= 0; $bab -= 5) {
            $ars[] = $ar;
            $ar -= 5;
        }

        return $ars;
    }

    /**
     * @return int
     */
    public function getBab()
    {
        $bab = 0;
        foreach ($this->getLevelPerClass() as $classLevel) {
            $bab += $classLevel['class']->getBab()[$classLevel['level'] - 1];
        }

        return $bab;
    }

    /**
     * Get this character's maximumhit points
     *
     * @return int
     */
    public function getMaxHp()
    {
        $hp = 0;
        foreach ($this->baseCharacter->getLevels() as $level) {
            $hp += $level->getHpRoll() + $this->getAbilityModifier($this->getConstitution());

            // Extra hit point if favored class
            if ($this->baseCharacter->getExtraPoint() === 'hp' && $level->isFavoredClass()) {
                $hp += 1;
            }
        }

        return $hp;
    }

    /**
     * @return array
     */
    public function getLevelPerClass()
    {
        /** @var $max Level[] */
        $levels = array();
        foreach ($this->baseCharacter->getLevels() as $level) {
            if(array_key_exists($level->getClassDefinition()->getId(), $levels)) {
                $levels[$level->getClassDefinition()->getId()]['level']++;
            } else {
                $levels[$level->getClassDefinition()->getId()] = array(
                    'class' => $level->getClassDefinition(),
                    'level' => 1
                );
            }
        }

        return $levels;
    }

    /**
     * Get the ability modifier corresponding to the value of the argument
     *
     * @param int $value
     *
     * @return int
     */
    public function getAbilityModifier($value)
    {
        return (int)(($value - ($value % 2) - 10) / 2);
    }

    /**
     * Get base reflexes
     *
     * @return int
     */
    public function getBaseReflexes()
    {
        $reflexes = 0;
        foreach ($this->getLevelPerClass() as $classLevel) {
            $reflexes += $classLevel['class']->getReflexes()[$classLevel['level'] - 1];
        }

        return $reflexes;
    }

    /**
     * Get reflexes (sum of base reflexes + dexterity modifier + bonuses
     *
     * @return int
     */
    public function getReflexes()
    {
        return $this->getBaseReflexes()
        + $this->getAbilityModifier($this->getDexterity())
        + $this->getReflexesBonus();
    }

    /**
     * Get base fortitude
     *
     * @return int
     */
    public function getBaseFortitude()
    {
        $fortitude = 0;
        foreach ($this->getLevelPerClass() as $classLevel) {
            $fortitude += $classLevel['class']->getFortitude()[$classLevel['level'] - 1];
        }

        return $fortitude;
    }

    /**
     * Get fortitude (sum of base fortitude + constitution modifier + bonuses
     *
     * @return int
     */
    public function getFortitude()
    {
        return $this->getBaseFortitude()
        + $this->getAbilityModifier($this->getConstitution())
        + $this->getFortitudeBonus();
    }

    /**
     * Get base will
     *
     * @return int
     */
    public function getBaseWill()
    {
        $will = 0;
        foreach ($this->getLevelPerClass() as $classLevel) {
            $will += $classLevel['class']->getWill()[$classLevel['level'] - 1];
        }

        return $will;
    }

    /**
     * Get will (sum of base will + wisdom modifier + bonuses
     *
     * @return int
     */
    public function getWill()
    {
        return $this->getBaseWill()
        + $this->getAbilityModifier($this->getWisdom())
        + $this->getWillBonus();
    }

    /**
     * Get this character's current level
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->baseCharacter->getLevel();
    }

    /**
     * @param $skill
     * @param $value
     */
    public function setSkillBonus($skill, $value)
    {
        $this->skillsBonuses[$skill] = $value;
    }

    /**
     * @param $skill
     *
     * @return int
     */
    public function getSkillBonus($skill)
    {
        if (array_key_exists($skill, $this->getSkillsBonuses())) {
            return $this->getSkillsBonuses()[$skill];
        }

        return 0;
    }

    /**
     * Return all feats this character possesses
     * @return ArrayCollection
     */
    public function getFeats()
    {
        $feats = array();
        foreach($this->getBaseCharacter()->getLevels() as $level) {
            $feats = array_merge($feats, $level->getFeats()->toArray());
        }

        return new ArrayCollection($feats);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 06/07/14
 * Time: 19:04
 */

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Troulite\PathfinderBundle\Model\AbilitiesBonuses;
use Troulite\PathfinderBundle\Model\AttackBonuses;
use Troulite\PathfinderBundle\Model\Bonus;
use Troulite\PathfinderBundle\Model\Bonuses;
use Troulite\PathfinderBundle\Model\CastableClassSpells;
use Troulite\PathfinderBundle\Model\DefenseBonuses;

/**
 * Class BaseCharacter
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\EntityListeners({ "Troulite\PathfinderBundle\Entity\Listener\CharacterListener" })
 *
 * @package Troulite\PathfinderBundle\Entity
 */
class Character extends BaseCharacter
{
    /**
     * @var Collection|Feat[]
     *
     * @ORM\OneToMany(targetEntity="InventoryItem", mappedBy="character", cascade={"all"}, orphanRemoval=true)
     */
    private $inventoryItems;

    /**
     * @var Collection|Level[]
     *
     * @ORM\OneToMany(targetEntity="Level", mappedBy="character", cascade={"all"})
     * @ORM\OrderBy({"id": "ASC"})
     */
    private $levels;

    /**
     * @var Collection|PreparedSpell[]
     *
     * @ORM\OneToMany(targetEntity="PreparedSpell", mappedBy="character", cascade={"all"}, orphanRemoval=true)
     */
    private $preparedSpells;

    /**
     * @var array Number of spells cast per class per spell level
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $nonPreparedCastSpellsCount;

    /**
     * @var Collection|SpellEffect[]
     *
     * @ORM\OneToMany(targetEntity="SpellEffect", mappedBy="character", cascade={"all"}, orphanRemoval=true)
     */
    private $spellEffects;

    /**
     * @var Collection|PowerEffect[]
     *
     * @ORM\OneToMany(targetEntity="PowerEffect", mappedBy="character", cascade={"all"}, orphanRemoval=true)
     */
    private $powerEffects;

    /**
     * @var AbilitiesBonuses
     */
    public $abilitiesBonuses;

    /**
     * @var AttackBonuses
     */
    private $attackBonuses;

    /**
     * @var DefenseBonuses
     */
    private $defenseBonuses;

    /**
     * @var Bonuses
     */
    private $hpBonuses;

    /**
     * @var Bonuses[]
     */
    private $skillsBonuses;

    /**
     * @var Bonuses
     */
    private $speedBonuses;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->postLoad();
        $this->levels = new ArrayCollection();
        $this->spellEffects = new ArrayCollection();
        $this->inventoryItems = new ArrayCollection();
    }

    /**
     * @ORM\PostLoad()
     */
    public function postLoad()
    {
        $this->abilitiesBonuses = new AbilitiesBonuses();
        $this->defenseBonuses   = new DefenseBonuses();
        $this->attackBonuses    = new AttackBonuses();
        $this->hpBonuses        = new Bonuses();
        $this->skillsBonuses    = array();
        $this->speedBonuses     = new Bonuses();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Get inventory
     *
     * @return InventoryItem[]|Collection
     */
    public function getInventoryItems()
    {
        return $this->inventoryItems;
    }

    /**
     * @param InventoryItem $inventoryItem
     *
     * @return $this
     */
    public function addInventoryItem(InventoryItem $inventoryItem)
    {
        foreach ($this->getInventoryItems() as $i) {
            if ($i->getItem() === $inventoryItem->getItem()) {
                $i->setQuantity($i->getQuantity() + $inventoryItem->getQuantity());
                return $this;
            }
        }

        $inventoryItem->setCharacter($this);
        $this->inventoryItems->add($inventoryItem);

        return $this;
    }

    /**
     * @param InventoryItem $inventoryItem
     *
     * @return $this
     */
    public function removeInventoryItem(InventoryItem $inventoryItem)
    {
        $this->getInventoryItems()->removeElement($inventoryItem);

        return $this;
    }

    /**
     * Add inventory
     *
     * @param Item $item
     * @param int $quantity
     *
     * @return $this
     */
    public function addInventory(Item $item, $quantity = 1)
    {
        if ($quantity < 1) {
            $quantity = 1;
        }

        foreach ($this->getInventoryItems() as $inventoryItem) {
            if ($inventoryItem->getItem() === $item) {
                $inventoryItem->setQuantity($inventoryItem->getQuantity() + 1);
                return $this;
            }
        }

        $inventoryItem = (new InventoryItem())->setCharacter($this)->setItem($item)->setQuantity($quantity);
        $this->inventoryItems[] = $inventoryItem;

        return $this;
    }

    /**
     * Remove inventory
     *
     * @param Item $item
     * @param int $quantity
     *
     * @return $this
     */
    public function removeInventory(Item $item, $quantity = 1)
    {
        foreach ($this->getInventoryItems() as $inventoryItem) {
            if ($inventoryItem->getItem() === $item) {

                if ($inventoryItem->getQuantity() <= $quantity) {
                    $this->getInventoryItems()->removeElement($inventoryItem);
                } else {
                    $inventoryItem->setQuantity($inventoryItem->getQuantity() - $quantity);
                }
                break;
            }
        }

        return $this;
    }

    /**
     * Add level
     *
     * @param Level $level
     *
     * @return $this
     */
    public function addLevel(Level $level)
    {
        $level->setCharacter($this);
        $this->levels[] = $level;

        return $this;
    }

    /**
     * Remove level
     *
     * @param Level $level
     */
    public function removeLevel(Level $level)
    {
        $level->setCharacter(null);
        $this->levels->removeElement($level);
    }

    /**
     * Get level
     *
     * @return Collection|Level[]
     */
    public function getLevels()
    {
        return $this->levels;
    }

    /**
     * @return AbilitiesBonuses
     */
    public function getAbilitiesBonuses()
    {
        return $this->abilitiesBonuses;
    }

    /**
     * @param AbilitiesBonuses $abilitiesBonuses
     */
    public function setAbilitiesBonuses($abilitiesBonuses)
    {
        $this->abilitiesBonuses = $abilitiesBonuses;
    }

    /**
     * @param Bonuses $hpBonuses
     *
     * @return $this
     */
    public function setHpBonuses(Bonuses $hpBonuses)
    {
        $this->hpBonuses = $hpBonuses;

        return $this;
    }

    /**
     * @return Bonuses
     */
    public function getHpBonuses()
    {
        return $this->hpBonuses;
    }

    /**
     * @param array $skillsBonuses
     */
    public function setSkillsBonuses($skillsBonuses)
    {
        $this->skillsBonuses = $skillsBonuses;
    }

    /**
     * @return Bonuses[]
     */
    public function &getSkillsBonuses()
    {
        return $this->skillsBonuses;
    }

    /**
     * @param AttackBonuses $attackBonuses
     */
    public function setAttackBonuses($attackBonuses)
    {
        $this->attackBonuses = $attackBonuses;
    }

    /**
     * @return AttackBonuses
     */
    public function getAttackBonuses()
    {
        return $this->attackBonuses;
    }

    /**
     * @param DefenseBonuses $defenseBonuses
     *
     * @return $this
     */
    public function setDefenseBonuses(DefenseBonuses $defenseBonuses)
    {
        $this->defenseBonuses = $defenseBonuses;

        return $this;
    }

    /**
     * @return DefenseBonuses
     */
    public function getDefenseBonuses()
    {
        return $this->defenseBonuses;
    }

    /**
     * @param Skill|string $skill
     *
     * @return int
     */
    public function getSkillRank($skill)
    {
        $rank = 0;
        $isSkillObject = is_object($skill);
        foreach ($this->getLevels() as $level) {
            foreach ($level->getSkills() as $levelSkill) {
                if (($isSkillObject && $levelSkill->getSkill() === $skill) ||
                    ((string)$skill) === $levelSkill->getSkill()->getName() ||
                    ((string)$skill) === $levelSkill->getSkill()->getShortname()
                ) {
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
     * @return int
     */
    public function getSkillValue(Skill $skill)
    {
        $value = $this->getSkillRank($skill) + $this->getModifierByAbility($skill->getKeyAbility(), $this);
        if ($this->hasClassBonus($skill) && $this->getSkillRank($skill) > 0) {
            $value += 3;
        }
        if (array_key_exists($skill->getShortname(), $this->getSkillsBonuses())) {
            $value += $this->getSkillsBonuses()[$skill->getShortname()]->getBonus();
        }

        return $value;
    }

    /**
     * @param Skill $skill
     *
     * @return bool
     */
    public function hasClassBonus(Skill $skill)
    {
        foreach ($this->getLevels() as $level) {
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
        return $this->attackBonuses->meleeDamage->getBonus() + $this->getAbilityModifier($this->getStrength());
    }

    /**
     * @return int
     */
    public function getRangedDamageRoll()
    {
        return $this->attackBonuses->rangedDamage->getBonus();
    }

    /**
     * Get strength
     *
     * @return integer
     */
    public function getStrength()
    {
        $levelBonus = 0;
        foreach ($this->getLevels() as $level) {
            if ($level->getExtraAbility() == Abilities::STRENGTH) {
                $levelBonus += 1;
            }
        }

        return
            $this->getAbilities()->getBaseStrength() +
            $this->getAbilitiesBonuses()->strength->getBonus() +
            $levelBonus;
    }

    /**
     * Get dexterity
     *
     * @return integer
     */
    public function getDexterity()
    {
        $levelBonus = 0;
        foreach ($this->getLevels() as $level) {
            if ($level->getExtraAbility() == Abilities::DEXTERITY) {
                $levelBonus += 1;
            }
        }

        return
            $this->getAbilities()->getBaseDexterity() +
            $this->getAbilitiesBonuses()->dexterity->getBonus() +
            $levelBonus;
    }

    /**
     * Get constitution
     *
     * @return integer
     */
    public function getConstitution()
    {
        $levelBonus = 0;
        foreach ($this->getLevels() as $level) {
            if ($level->getExtraAbility() == Abilities::CONSTITUTION) {
                $levelBonus += 1;
            }
        }

        return
            $this->getAbilities()->getBaseConstitution() +
            $this->getAbilitiesBonuses()->constitution->getBonus() +
            $levelBonus;
    }

    /**
     * Get intelligence
     *
     * @return integer
     */
    public function getIntelligence()
    {
        $levelBonus = 0;
        foreach ($this->getLevels() as $level) {
            if ($level->getExtraAbility() == Abilities::INTELLIGENCE) {
                $levelBonus += 1;
            }
        }

        return
            $this->getAbilities()->getBaseIntelligence() +
            $this->getAbilitiesBonuses()->intelligence->getBonus() +
            $levelBonus;
    }

    /**
     * Get wisdom
     *
     * @return integer
     */
    public function getWisdom()
    {
        $levelBonus = 0;
        foreach ($this->getLevels() as $level) {
            if ($level->getExtraAbility() == Abilities::WISDOM) {
                $levelBonus += 1;
            }
        }

        return
            $this->getAbilities()->getBaseWisdom() +
            $this->getAbilitiesBonuses()->wisdom->getBonus() +
            $levelBonus;
    }

    /**
     * Get charisma
     *
     * @return integer
     */
    public function getCharisma()
    {
        $levelBonus = 0;
        foreach ($this->getLevels() as $level) {
            if ($level->getExtraAbility() == Abilities::CHARISMA) {
                $levelBonus += 1;
            }
        }

        return
            $this->getAbilities()->getBaseCharisma() +
            $this->getAbilitiesBonuses()->charisma->getBonus() +
            $levelBonus;
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
                $ar += $this->attackBonuses->rangedAttackRolls->getBonus();
                $bonusAttacks = $this->attackBonuses->rangedAttacks->getBonus();
                break;
            case 'melee':
                $ar += $this->attackBonuses->meleeAttackRolls->getBonus();
                $bonusAttacks = $this->attackBonuses->meleeAttacks->getBonus();
        }

        /** @noinspection PhpExpressionResultUnusedInspection */
        for ($bonusAttacks; $bonusAttacks > 0; $bonusAttacks--) {
            $ars[] = $ar;
        }
        /** @noinspection PhpExpressionResultUnusedInspection */
        for ($bab; $bab > 0; $bab -= 5) {
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
            /** @var $class ClassDefinition */
            $class = $classLevel['class'];
            $bab += $class->getBab()[$classLevel['level'] - 1];
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
        $hp = $this->getHpBonuses()->getBonus();
        foreach ($this->getLevels() as $level) {
            $hp += $level->getHpRoll() + $this->getAbilityModifier($this->getConstitution());

            // Extra hit point if favored class
            if ($level->getExtraPoint() === 'hp' && $level->isFavoredClass()) {
                $hp += 1;
            }
        }

        return $hp;
    }

    /**
     * @param int $mod how many HP to add or remove
     *
     * @return $this
     */
    public function changeHp($mod)
    {
        $this->setLostHP(max(0, $this->getLostHP() - $mod));

        return $this;
    }

    /**
     * @return array
     */
    public function getLevelPerClass()
    {
        /** @var $levels array */
        $levels = array();
        foreach ($this->getLevels() as $level) {
            $class = $level->getClassDefinition();
            if ($class) {
                if (array_key_exists($class->getId(), $levels)) {
                    $levels[$class->getId()]['level']++;
                } else {
                    $levels[$class->getId()] = array(
                        'class' => $class,
                        'level' => 1
                    );
                }
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
            /** @var $class ClassDefinition */
            $class = $classLevel['class'];
            $reflexes += $class->getReflexes()[$classLevel['level'] - 1];
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
        + $this->getDefenseBonuses()->reflexes->getBonus();
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
            /** @var $class ClassDefinition */
            $class = $classLevel['class'];
            $fortitude += $class->getFortitude()[$classLevel['level'] - 1];
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
        + $this->getDefenseBonuses()->fortitude->getBonus();
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
            /** @var $class ClassDefinition */
            $class = $classLevel['class'];
            $will += $class->getWill()[$classLevel['level'] - 1];
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
        + $this->getDefenseBonuses()->will->getBonus();
    }

    /**
     * Get this character's current level
     *
     * @param int|ClassDefinition $class
     *
     * @return int
     */
    public function getLevel($class = null)
    {
        if ($class) {
            $id = null;
            if (is_object($class) && $class instanceof ClassDefinition) {
                $id = $class->getId();
            } elseif (is_numeric($class)) {
                $id = $class;
            }

            return $this->getLevelPerClass()[$id]['level'];
        }

        return $this->getLevels()->count();
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
     * @param Bonuses $speedBonuses
     */
    public function setSpeedBonuses($speedBonuses)
    {
        $this->speedBonuses = $speedBonuses;
    }

    /**
     * @return Bonuses
     */
    public function getSpeedBonuses()
    {
        return $this->speedBonuses;
    }

    /**
     * Return all feats this character possesses
     * @return ArrayCollection|CharacterFeat[]
     */
    public function getFeats()
    {
        $feats = array();
        foreach($this->getLevels() as $level) {
            $feats = array_merge($feats, $level->getFeats()->toArray());
        }

        return new ArrayCollection($feats);
    }

    /**
     * Return all class powers this character possesses
     *
     * @return Collection|CharacterClassPower[]
     */
    public function getClassPowers()
    {
        $classPowers = array();
        foreach ($this->getLevels() as $level) {
            $classPowers = array_merge($classPowers, $level->getClassPowers()->toArray());
        }

        return new ArrayCollection($classPowers);
    }

    /**
     * @todo dexterity modifier limited by armor
     * @todo bonuses
     * @return int
     */
    public function getAc()
    {
        $maxDexShield = 1000;
        if ($this->getEquipment()->getOffhandWeapon() instanceof Shield) {
            $maxDexShield = $this->getEquipment()->getOffhandWeapon()->getMaximumDexterityBonus();
        }
        if ($this->getEquipment()->getArmor()) {
            return
                10 +
                min(
                    $this->getAbilityModifier($this->getDexterity()),
                    $this->getEquipment()->getArmor()->getMaximumDexterityBonus(),
                    $maxDexShield
                ) +
                $this->getDefenseBonuses()->ac->getBonus();
        } else {
            return
                10 +
                $this->getAbilityModifier($this->getDexterity()) +
                $this->getDefenseBonuses()->ac->getBonus();
        }
    }

    /**
     * @todo bonuses
     * @return int
     */
    public function getTouchAc()
    {
        if ($this->getEquipment()->getArmor()) {
            return
                10 +
                min(
                    $this->getAbilityModifier($this->getDexterity()),
                    $this->getEquipment()->getArmor()->getMaximumDexterityBonus()
                ) +
                $this->getDodgeBonus();
        } else {
            return 10 + $this->getAbilityModifier($this->getDexterity()) + $this->getDodgeBonus();
        }
    }

    /**
     * Flat-footed AC doesn't take dexterity or dodge bonus
     * @return int
     */
    public function getFlatFootedAc()
    {
        return 10 + $this->getDefenseBonuses()->ac->getBonus() - $this->getDodgeBonus();
    }

    /**
     * @return int
     */
    public function getInitiative()
    {
        return $this->getAbilityModifier($this->getDexterity()) +
            $this->getAttackBonuses()->initiative->getBonus();
    }

    /**
     * @param string $ability
     *
     * @return int
     */
    public function getModifierByAbility($ability)
    {
        switch ($ability) {
            case 'strength':
                return $this->getAbilityModifier($this->getStrength());
            case 'dexterity':
                return $this->getAbilityModifier($this->getDexterity());
            case 'constitution':
                return $this->getAbilityModifier($this->getConstitution());
            case 'intelligence':
                return $this->getAbilityModifier($this->getIntelligence());
            case 'wisdom':
                return $this->getAbilityModifier($this->getWisdom());
            case 'charisma':
                return $this->getAbilityModifier($this->getCharisma());
        }
        return 0;
    }

    /**
     * @return int
     */
    public function getAvailableSkillPoints()
    {
        $available = 0;

        // Intelligence modifier (profile only).
        $intelligence = $this->getAbilities()->getBaseIntelligence();
        foreach ($this->getLevels() as $level) {
            if ($level->getExtraAbility() == Abilities::INTELLIGENCE) {
                $intelligence++;
            }
        }
        // Racial intelligence bonuses
        foreach ($this->getAbilitiesBonuses()->intelligence->getBonuses() as $bonus) {
            if ($bonus->getType() == 'racial') {
                $intelligence += $bonus->getValue();
            }
        }

        foreach ($this->getLevels() as $level) {
            $levelPoints = $level->getClassDefinition()->getSkillPoints();

            // Add Intelligence mod. Available points can't be < 1 after applying intelligence
            $levelPoints += $this->getAbilityModifier($intelligence);
            if ($levelPoints < 1) {
                $levelPoints = 1;
            }

            // Add skill bonus for favored classes
            if (
                $level->getClassDefinition() === $this->getFavoredClass() &&
                $level->getExtraPoint() === 'skill'
            ) {
                $levelPoints++;
            }

            // Racial Bonus
            $traits = $this->getRace()->getTraits();
            if (array_key_exists('extra_skills_per_level', $traits)) {
                $levelPoints += $traits['extra_skills_per_level']['value'];
            }

            // Subtract spent points
            foreach ($level->getSkills() as $levelSkill) {
                $levelPoints -= $levelSkill->getValue();
            }

            $available += $levelPoints;
        }

        return $available;
    }

    /**
     * Get the list of dodge bonuses
     *
     * @return Bonus[]
     */
    public function getDodgeBonuses()
    {
        /** @var $dodgeBonuses Bonus[] */
        $dodgeBonuses = array_filter(
            $this->getDefenseBonuses()->ac->getBonuses(),
            function (Bonus $bonus) {
                return $bonus->getType() === 'dodge';
            }
        );

        return $dodgeBonuses;
    }

    /**
     * Get total dodge bonus
     *
     * @return int
     */
    public function getDodgeBonus()
    {
        $dodgeBonuses = $this->getDodgeBonuses();

        $dodgeBonus = 0;
        foreach ($dodgeBonuses as $db) {
            $dodgeBonus += $db->getValue();
        }

        return $dodgeBonus;
    }

    /**
     * @param SpellEffect $spellEffect
     *
     * @return $this
     */
    public function addSpellEffect(SpellEffect $spellEffect)
    {
        $spellEffect->setCharacter($this);
        $this->spellEffects->add($spellEffect);

        return $this;
    }

    /**
     * @param SpellEffect $spellEffect
     *
     * @return $this
     */public function removeSpellEffect(SpellEffect $spellEffect)
    {
        $this->spellEffects->removeElement($spellEffect);

        return $this;
    }

    /**
     * @param Collection|SpellEffect[] $spellEffects
     *
     * @return $this
     */
    public function setSpellEffects($spellEffects)
    {
        $this->spellEffects = $spellEffects;

        return $this;
    }

    /**
     * @return Collection|SpellEffect[]
     */
    public function getSpellEffects()
    {
        return $this->spellEffects;
    }

    /**
     * Return empty array if no known spells or if no class has to learn spells
     * @return ClassSpell[]
     */
    public function getLearnedSpells()
    {
        $known = array();
        $spellsBySpellLevel = $this->getLearnedSpellsBySpellLevel();
        ksort($spellsBySpellLevel);
        foreach ($spellsBySpellLevel as $spells) {
            $known = array_merge($known, $spells);
        }

        return $known;
    }

    /**
     * Return empty array if no known spells or if no class has to learn spells
     *
     * @return array
     */
    public function getLearnedSpellsBySpellLevel()
    {
        $known = array();
        foreach ($this->getLevels() as $level) {
            foreach ($level->getLearnedSpells() as $classSpell) {
                $known[$classSpell->getSpellLevel()][$classSpell->getId()] = $classSpell;
            }
        }

        return $known;
    }

    /**
     * Add preparedSpell
     *
     * @param PreparedSpell $preparedSpell
     *
     * @return $this
     */
    public function addPreparedSpell(PreparedSpell $preparedSpell)
    {
        $this->preparedSpells[] = $preparedSpell;
        $preparedSpell->setCharacter($this);

        return $this;
    }

    /**
     * Remove preparedSpells
     *
     * @param PreparedSpell $preparedSpell
     */
    public function removePreparedSpell(PreparedSpell $preparedSpell)
    {
        $this->preparedSpells->removeElement($preparedSpell);
    }

    /**
     * @param Collection $preparedSpells
     */
    public function setPreparedSpells(Collection $preparedSpells)
    {
        $this->preparedSpells = $preparedSpells;
    }

    /**
     * Get preparedSpells
     *
     * @return PreparedSpell[]|Collection
     */
    public function getPreparedSpells()
    {
        return $this->preparedSpells;
    }

    /**
     * @return array
     */
    public function getPreparedSpellsByLevel()
    {
        $preparedSpellsByLevel = array();
        foreach ($this->getPreparedSpells() as $preparedSpell) {
            $preparedSpellsByLevel[$preparedSpell->getSpellLevel()][] = $preparedSpell;
        }
        return $preparedSpellsByLevel;
    }

    /**
     * keys: ClassDefinition
     * data: array of spell level keys, list of spells
     * @return \SplObjectStorage
     */
    public function getCastableSpellsByClassBySpellLevel()
    {
        /** @var CastableClassSpells[] $spells */
        $spells = array();
        foreach ($this->getPreparedSpells() as $preparedSpell) {
            if ($preparedSpell->isAlreadyCast()) {
                continue;
            }

            $castableClassSpells = $preparedSpell->getClass();
            if (!array_key_exists($castableClassSpells->getId(), $spells)) {
                $spells[$castableClassSpells->getId()] = (new CastableClassSpells())->setClass($castableClassSpells);
            }

            $spells[$castableClassSpells->getId()]->addSpellToLevel(
                $preparedSpell->getSpell(),
                $preparedSpell->getSpellLevel()
            );
        }

        foreach ($this->getLearnedSpells() as $learnedSpell) {
            $castableClassSpells = $learnedSpell->getClass();
            if (!array_key_exists($castableClassSpells->getId(), $spells)) {
                $spells[$castableClassSpells->getId()] = (new CastableClassSpells())->setClass($castableClassSpells);
            }

            $spells[$castableClassSpells->getId()]->addSpellToLevel(
                $learnedSpell->getSpell(),
                $learnedSpell->getSpellLevel()
            );
        }

        return $spells;
    }

    /**
     * @param Spell $spell
     * @param ClassDefinition $class
     *
     * @return null|PreparedSpell
     */
    public function getPreparedSpell(Spell $spell, ClassDefinition $class)
    {
        foreach ($this->getPreparedSpells() as $preparedSpell) {
            if ($preparedSpell->getSpell() === $spell && $preparedSpell->getClass() === $class) {
                return $preparedSpell;
            }
        }

        return null;
    }

    /**
     * @param Spell $spell
     * @param ClassDefinition $class
     *
     * @return null|ClassSpell
     */
    public function getLearnedSpell(Spell $spell, ClassDefinition $class)
    {
        foreach ($this->getLearnedSpells() as $classSpell) {
            if ($classSpell->getSpell() === $spell && $classSpell->getClass() === $class) {
                return $classSpell;
            }
        }

        return null;
    }

    /**
     * Set nonPreparedCastSpellsCount
     *
     * @param array $nonPreparedCastSpellsCount
     *
     * @return $this
     */
    public function setNonPreparedCastSpellsCount($nonPreparedCastSpellsCount)
    {
        $this->nonPreparedCastSpellsCount = $nonPreparedCastSpellsCount;

        return $this;
    }

    /**
     * Get nonPreparedCastSpellsCount
     *
     * @return array 
     */
    public function getNonPreparedCastSpellsCount()
    {
        return $this->nonPreparedCastSpellsCount;
    }

    /**
     * @return array
     */
    public function getCastablePerDayPerClass()
    {
        $castable = array();
        foreach ($this->getClasses() as $class) {
            $classPerDay = $class->getSpellsPerDay();
            $castable[$class->getId()] = $classPerDay;
        }

        return $castable;
    }

    /**
     * Add powerEffects
     *
     * @param PowerEffect $powerEffect
     *
     * @return Character
     */
    public function addPowerEffect(PowerEffect $powerEffect)
    {
        foreach ($this->powerEffects as $pe) {
            if ($powerEffect->getPower() === $pe->getPower() && $powerEffect->getCaster() === $pe->getCaster()) {
                return $this;
            }
        }
        $powerEffect->setCharacter($this);
        $this->powerEffects[] = $powerEffect;

        return $this;
    }

    /**
     * Remove powerEffect
     *
     * @param PowerEffect $powerEffect
     */
    public function removePowerEffect(PowerEffect $powerEffect)
    {
        $this->powerEffects->removeElement($powerEffect);
    }

    /**
     * Get powerEffects
     *
     * @return Collection|PowerEffect[]
     */
    public function getPowerEffects()
    {
        return $this->powerEffects;
    }

    /**
     * @return ClassDefinition[]
     */
    private function getClasses()
    {
        $classes = array();
        foreach ($this->getLevels() as $level) {
            if (!in_array($level->getClassDefinition(), $classes)) {
                $classes[] = $level->getClassDefinition();
            }
        }
        return $classes;
    }

    /**
     * @return InventoryItem[]|Collection
     */
    public function getUnequippedInventory()
    {
        return $this->getInventoryItems();
        /*
        return $this->getInventory()->filter(
            function (InventoryItem $inventoryItem) {
                return $this->getEquipment()->isEquipped($inventoryItem->getItem()) < $inventoryItem->getQuantity();
            }
        );
        */
    }

    /**
     * Dummy function to be able to use unequipped_inventory in forms
     *
     * @param $inventory
     *
     * @return $this
     */
    public function setUnequippedInventory(
        /** @noinspection PhpUnusedParameterInspection */
        Collection $inventory)
    {
        return $this;
    }
}

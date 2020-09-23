<?php

namespace App\Entity\Characters;

use App\Entity\Items\Item;
use App\Entity\Items\Shield;
use App\Entity\Items\Weapon;
use App\Entity\Rules\Abilities;
use App\Entity\Rules\ClassDefinition;
use App\Entity\Rules\ClassSpell;
use App\Entity\Rules\Feat;
use App\Entity\Rules\Skill;
use App\Entity\Rules\Spell;
use App\Model\AbilitiesBonuses;
use App\Model\AttackBonuses;
use App\Model\Bonus;
use App\Model\Bonuses;
use App\Model\CastableClassSpells;
use App\Model\DefenseBonuses;
use App\Model\SpellSlotBonuses;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class BaseCharacter
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Character extends BaseCharacter
{
    /**
     * @var Collection|Feat[]
     *
     * @ORM\OneToMany(targetEntity=InventoryItem::class, mappedBy="character", cascade={"all"}, orphanRemoval=true)
     */
    protected $inventoryItems;

    /**
     * @var Collection|Level[]
     *
     * @ORM\OneToMany(targetEntity=Level::class, mappedBy="character", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"id": "ASC"})
     */
    protected $levels;

    /**
     * @var Collection|PreparedSpell[]
     *
     * @ORM\OneToMany(targetEntity=PreparedSpell::class, mappedBy="character", cascade={"all"}, orphanRemoval=true)
     */
    protected $preparedSpells;

    /**
     * @var array Number of spells cast per class per spell level
     *
     * @ORM\Column(type="json", nullable=true)
     */
    protected $nonPreparedCastSpellsCount;

    /**
     * @var Collection|SpellEffect[]
     *
     * @ORM\OneToMany(targetEntity=SpellEffect::class, mappedBy="character", cascade={"all"}, orphanRemoval=true)
     */
    protected $spellEffects;

    /**
     * @var Collection|PowerEffect[]
     *
     * @ORM\OneToMany(targetEntity=PowerEffect::class, mappedBy="character", cascade={"all"}, orphanRemoval=true)
     */
    protected $powerEffects;

    /**
     * @var Collection|ItemPowerEffect[]
     *
     * @ORM\OneToMany(targetEntity=ItemPowerEffect::class, mappedBy="character", cascade={"all"}, orphanRemoval=true)
     */
    protected $itemPowerEffects;

    /**
     * @var AbilitiesBonuses
     */
    public $abilitiesBonuses;

    /**
     * @var AttackBonuses
     */
    protected $attackBonuses;

    /**
     * @var DefenseBonuses
     */
    protected $defenseBonuses;

    /**
     * @var Bonuses
     */
    protected $hpBonuses;

    /**
     * @var Bonuses[]
     */
    protected $skillsBonuses;

    /**
     * @var Bonuses
     */
    protected $speedBonuses;

    /**
     * @var SpellSlotBonuses
     */
    protected $spellSlotBonuses;

    /**
     * @var Collection|Counter[]
     *
     * @ORM\OneToMany(targetEntity=Counter::class, mappedBy="character", cascade={"all"})
     */
    protected $counters;

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
        $this->counters = new ArrayCollection();
    }

    /**
     * @ORM\PostLoad()
     */
    public function postLoad()
    {
        if (!$this->abilitiesBonuses) $this->abilitiesBonuses = new AbilitiesBonuses();
        if (!$this->defenseBonuses)   $this->defenseBonuses   = new DefenseBonuses();
        if (!$this->attackBonuses)    $this->attackBonuses    = new AttackBonuses();
        if (!$this->hpBonuses)        $this->hpBonuses        = new Bonuses();
        if (!$this->skillsBonuses)    $this->skillsBonuses    = array();
        if (!$this->speedBonuses)     $this->speedBonuses     = new Bonuses();
        if (!$this->spellSlotBonuses) $this->spellSlotBonuses = new SpellSlotBonuses();
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
     * @param Item|null $item
     * @param int       $quantity
     *
     * @return $this
     */
    public function addInventory(Item $item = null, $quantity = 1)
    {
        if (!$item) {
            return $this;
        }

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
    public function setAbilitiesBonuses(AbilitiesBonuses $abilitiesBonuses)
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
    public function setSkillsBonuses(array $skillsBonuses)
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
    public function setAttackBonuses(AttackBonuses $attackBonuses)
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
                    ((string)$skill) === $levelSkill->getSkill() ||
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
        $value = $this->getSkillRank($skill) + $this->getModifierByAbility($skill->getKeyAbility());
        if ($this->hasClassBonus($skill) && $this->getSkillRank($skill) > 0) {
            $value += 3;
        }
        if (array_key_exists($skill->getShortname(), $this->getSkillsBonuses())) {
            $bonuses = $this->getSkillsBonuses()[$skill->getShortname()];
            $value += $bonuses->getBonus();
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
    public function getMainAttackRoll()
    {
        $weapon = $this->getEquipment()->getMainWeapon();

        if (!$weapon || $weapon->getRange() == 0) {
            $mod = $this->getModifierByAbility('strength');
        } else {
            $mod = $this->getModifierByAbility('dexterity');
        }

        $bab          = $this->getBab();
        $ar           = $bab + $mod;
        $ars          = array();

        $ar += $this->attackBonuses->mainAttackRolls->getBonus();
        $bonusAttacks = $this->attackBonuses->mainAttacks->getBonus();

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
     * @return array
     */
    public function getOffhandAttackRoll()
    {
        $weapon = $this->getEquipment()->getOffhandWeapon();

        if (!$weapon || $weapon->getRange() == 0) {
            $mod = $this->getModifierByAbility('strength');
        } else {
            $mod = $this->getModifierByAbility('dexterity');
        }

        $bab = $this->getBab();
        $ar  = $bab + $mod;
        $ars = array();

        $ar += $this->attackBonuses->offhandAttackRolls->getBonus();
        $bonusAttacks = $this->attackBonuses->offhandAttacks->getBonus();

        $ars[] = $ar;

        /** @noinspection PhpExpressionResultUnusedInspection */
        for ($bonusAttacks; $bonusAttacks > 0; $bonusAttacks--) {
            $ars[] = $ar - 5;
            // Off-hand bonus attacks get the -5/-10 for secondary/tertiary attacks
            // That is actually wrong, because this is only the case with two-weapon fighting feats
            // but I think that's the only way to get more off-hand attacks, so that's good enough
            $ar -=5;
        }

        return $ars;
    }

    /**
     * @return array
     */
    public function getMeleeAttackRoll()
    {
        return $this->getAttackRoll("melee", $this->getModifierByAbility('strength'));
    }

    /**
     * @return array
     */
    public function getRangedAttackRoll()
    {
        return $this->getAttackRoll("ranged", $this->getModifierByAbility('dexterity'));
    }

    /**
     * @return int
     */
    public function getMainDamageRoll()
    {
        $weapon = $this->getEquipment()->getMainWeapon();

        if (!$weapon || $weapon->getRange() == 0) {
            $mod = $this->getModifierByAbility('strength');
        } else {
            $mod = 0;
        }

        return $this->attackBonuses->mainDamage->getBonus() + $mod;
    }

    /**
     * @return int
     */
    public function getOffhandDamageRoll()
    {
        $weapon = $this->getEquipment()->getOffhandWeapon();

        if (!$weapon || $weapon->getRange() == 0) {
            $mod = (int) $this->getModifierByAbility('strength') / 2;
        } else {
            $mod = 0;
        }

        return $this->attackBonuses->offhandDamage->getBonus() + $mod;
    }

    /**
     * @return int
     */
    public function getMeleeDamageRoll()
    {
        return $this->attackBonuses->meleeDamage->getBonus() + $this->getModifierByAbility('strength');
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
            $hp += $level->getHpRoll() + $this->getModifierByAbility('constitution');

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
    public function changeHp(int $mod)
    {
        $this->setLostHP(max(0, $this->getLostHP() - $mod));

        return $this;
    }

    /**
     * @return array
     */
    public function getLevelPerClass()
    {
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
    public function getAbilityModifier(int $value)
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
        + $this->getModifierByAbility('dexterity')
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
        + $this->getModifierByAbility('constitution')
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
        + $this->getModifierByAbility('wisdom')
        + $this->getDefenseBonuses()->will->getBonus();
    }

    /**
     * Get this character's current level
     *
     * @param null $class
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
     * @return int|Bonuses
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
    public function setSpeedBonuses(Bonuses $speedBonuses)
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
     * @return SpellSlotBonuses
     */
    public function getSpellSlotBonuses()
    {
        return $this->spellSlotBonuses;
    }

    /**
     * @param SpellSlotBonuses $spellSlotBonuses
     *
     * @return $this
     */
    public function setSpellSlotBonuses(SpellSlotBonuses $spellSlotBonuses)
    {
        $this->spellSlotBonuses = $spellSlotBonuses;
        return $this;
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
     * @return int
     */
    public function getAc()
    {
        return 10 + $this->getModifierByAbility('dexterity') + $this->getDefenseBonuses()->ac->getBonus();
    }

    /**
     * @todo bonuses
     * @return int
     */
    public function getTouchAc()
    {
        return 10 + $this->getModifierByAbility('dexterity') + $this->getDodgeBonus();
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
        return $this->getModifierByAbility('dexterity') +
            $this->getAttackBonuses()->initiative->getBonus();
    }

    /**
     * @param string $ability
     *
     * @return int
     */
    public function getModifierByAbility(string $ability)
    {
        switch ($ability) {
            case 'strength':
                return $this->getAbilityModifier($this->getStrength());
            case 'dexterity':
                $mod         = $this->getAbilityModifier($this->getDexterity());
                $maxDexBonus = $this->getMaximumDexterityBonus();

                if ($maxDexBonus) {
                    return min($mod, $maxDexBonus);
                }
                return $mod;
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
     * Get maximum dexterity bonus dependent on armor and shield
     * @return int|null maximum dexterity bonus or null if no limit
     */
    public function getMaximumDexterityBonus()
    {
        $max = null;
        $armor  = $this->getEquipment()->getArmor();
        $shield = $this->getEquipment()->getOffhandWeapon();
        $shield2 = $this->getEquipment()->getMainWeapon(); // there could be two shields

        if ($armor) {
            $max = $armor->getMaximumDexterityBonus();
        }
        if ($shield && $shield instanceof Shield && $shield->getMaximumDexterityBonus() < $max) {
            $max = $shield->getMaximumDexterityBonus();
        }
        if ($shield2 && $shield2 instanceof Shield && $shield2->getMaximumDexterityBonus() < $max) {
            $max = $shield2->getMaximumDexterityBonus();
        }

        foreach ($this->getAbilitiesBonuses()->maxDexterityBonuses->getApplicableBonuses() as $bonus) {
            $max += $bonus->getValue();
        }

        return $max;
    }

    /**
     * @return int
     */
    public function getShieldCheckPenalty()
    {
        $value = 0;
        $shield  = $this->getEquipment()->getOffhandWeapon();
        $shield2 = $this->getEquipment()->getMainWeapon(); // there could be two shields

        if ($shield && $shield instanceof Shield) {
            $value += $shield->getArmorCheckPenalty();
        }
        if ($shield2 && $shield2 instanceof Shield) {
            $value += $shield2->getArmorCheckPenalty();
        }

        return $value;
    }

    /**
     * @return int
     */
    public function getArmorCheckPenalty()
    {
        $value   = 0;
        $armor   = $this->getEquipment()->getArmor();

        if ($armor) {
            $value += $armor->getArmorCheckPenalty();
        }

        return $value + $this->getShieldCheckPenalty();
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
        $known = array_merge($known, $this->getExtraSpells()->toArray());

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

        foreach ($this->getExtraSpells() as $classSpell) {
            $known[$classSpell->getSpellLevel()][$classSpell->getId()] = $classSpell;
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
     * Remove preparedSpell
     *
     * @param PreparedSpell $preparedSpell reference to a prepared spell (allowing effective call to setCharacter)
     */
    public function removePreparedSpell(PreparedSpell $preparedSpell)
    {
        $this->preparedSpells->removeElement($preparedSpell);
        $preparedSpell->setCharacter(null);
    }

    /**
     * @param Collection $preparedSpells
     */
    public function setPreparedSpells(Collection $preparedSpells)
    {
        foreach ($preparedSpells as $ps) {
            $this->removePreparedSpell($ps);
        }
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
     * @return CastableClassSpells[]
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
            if ($learnedSpell->getClass()->isPreparationNeeded()) {
                continue;
            }
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
     * @param array|null $nonPreparedCastSpellsCount
     *
     * @return $this
     */
    public function setNonPreparedCastSpellsCount(?array $nonPreparedCastSpellsCount)
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
     * Add itemPowerEffects
     *
     * @param ItemPowerEffect $itemPowerEffect
     *
     * @return Character
     */
    public function addItemPowerEffect(ItemPowerEffect $itemPowerEffect)
    {
        foreach ($this->itemPowerEffects as $pe) {
            if ($itemPowerEffect->getPower() === $pe->getPower()) {
                return $this;
            }
        }
        $itemPowerEffect->setCharacter($this);
        $this->itemPowerEffects[] = $itemPowerEffect;

        return $this;
    }

    /**
     * Remove itemPowerEffect
     *
     * @param ItemPowerEffect $itemPowerEffect
     */
    public function removeItemPowerEffect(ItemPowerEffect $itemPowerEffect)
    {
        $this->itemPowerEffects->removeElement($itemPowerEffect);
    }

    /**
     * Get itemPowerEffects
     *
     * @return Collection|ItemPowerEffect[]
     */
    public function getItemPowerEffects()
    {
        return $this->itemPowerEffects;
    }


    /**
     * @return ClassDefinition[]
     */
    public function getClasses()
    {
        $classes = array();
        foreach ($this->getLevels() as $level) {
            if (!in_array($level->getClassDefinition(), $classes, true)) {
                $classes[] = $level->getClassDefinition();
            }
        }
        return $classes;
    }

    /**
     * @param ClassDefinition|null $class
     *
     * @return array
     */
    public function getSubClassesFor(ClassDefinition $class)
    {
        $res = array();
        foreach ($this->getLevels() as $l) {
            if ($l->getSubClasses()->count() > 0 && $l->getClassDefinition() === $class) {
                $res = array_merge($res, $l->getSubClasses()->toArray());
            }
        }
        return $res;
    }

    /**
     * @return InventoryItem[]|Collection
     */
    public function getUnequippedInventory()
    {
        return $this->getInventoryItems();
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

    /**
     * @return Collection|Counter[]
     */
    public function getCounters()
    {
        return $this->counters;
    }

    /**
     * @param Counter $counter
     *
     * @return $this
     */
    public function addCounter(Counter $counter)
    {
        $this->counters->add($counter);

        return $this;
    }

    /**
     * @param Counter $counter
     *
     * @return $this
     */
    public function removeCounter(Counter $counter)
    {
        $this->counters->removeElement($counter);

        return $this;
    }

    /**
     * @return bool
     */
    public function isDualWielding()
    {
        return $this->getEquipment()->getMainWeapon() instanceof Weapon &&
            $this->getEquipment()->getOffhandWeapon() instanceof Weapon;
    }

    /**
     * @return bool
     */
    public function canLearnSpells()
    {
        foreach ($this->getClasses() as $class) {
            if ($class->isAbleToLearnNewSpells()) {
                return true;
            }
        }

        return false;
    }
}

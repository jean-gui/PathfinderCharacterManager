<?php

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Troulite\PathfinderBundle\ExpressionLanguage\ExpressionLanguage;

/**
 * Character
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Character
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="characters")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Race")
     * @ORM\JoinColumn(name="race_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $race;

    /**
     * @var Collection|Level[]
     *
     * @ORM\OneToMany(targetEntity="Level", mappedBy="character", cascade={"all"})
     */
    private $levels;

    /**
     * @var ClassDefinition
     *
     * @ORM\ManyToOne(targetEntity="ClassDefinition")
     * @ORM\JoinColumn(name="favoredClass", referencedColumnName="id", nullable=false)
     */
    private $favoredClass;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $lostHP = 0;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $baseStrength;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $baseDexterity;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $baseConstitution;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $baseIntelligence;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $baseWisdom;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $baseCharisma;

    /**
     * @var Collection|Feat[]
     *
     * @ORM\OneToMany(targetEntity="CharacterFeat", mappedBy="character", cascade={"all"})
     */
    private $feats;

    /**
     * @var Collection|Feat[]
     *
     * @ORM\ManyToMany(targetEntity="Item")
     * @ORM\JoinTable(name="inventories",
     *      joinColumns={@ORM\JoinColumn(name="character_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id")}
     *      )
     */
    private $inventory;

    /**
     * @var Weapon $leftWeapon
     *
     * @ORM\ManyToOne(targetEntity="Weapon")
     * @ORM\JoinColumn(name="left_weapon_item_id", referencedColumnName="id")
     */
    private $leftWeapon;

    /**
     * @var Weapon $rightWeapon
     *
     * @ORM\ManyToOne(targetEntity="Weapon")
     * @ORM\JoinColumn(name="right_weapon_item_id", referencedColumnName="id")
     */
    private $rightWeapon;

    /**
     * @var Item $body
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="body_item_id", referencedColumnName="id")
     */
    private $body;

    /**
     * @var Item $leftFinger
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="left_finger_item_id", referencedColumnName="id")
     */
    private $leftFinger;

    /**
     * @var Item $rightFinger
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="right_finger_item_id", referencedColumnName="id")
     */
    private $rightFinger;

    /**
     * @var Item $feet
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="feet_item_id", referencedColumnName="id")
     */
    private $feet;

    /**
     * @var Item $neck
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="neck_item_id", referencedColumnName="id")
     */
    private $neck;

    /**
     * @var Item $back
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="back_item_id", referencedColumnName="id")
     */
    private $back;

    /**
     * @var Item $head
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="head_item_id", referencedColumnName="id")
     */
    private $head;

    /**
     * @var Item $belt
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="belt_item_id", referencedColumnName="id")
     */
    private $belt;

    /**
     * @var Item $hands
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="hands_item_id", referencedColumnName="id")
     */
    private $hands;

    /**
     * @var Party
     *
     * @ORM\ManyToOne(targetEntity="Party", inversedBy="characters")
     * @ORM\JoinColumn(name="party_id", referencedColumnName="id")
     */
    private $party;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->level = new ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Character
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set race
     *
     * @param Race $race
     * @return Character
     */
    public function setRace(Race $race = null)
    {
        $this->race = $race;

        return $this;
    }

    /**
     * Get race
     *
     * @return Race
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * Add level
     *
     * @param Level $level
     * @return Character
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

    public function getLevel()
    {
        return $this->getLevels()->count();
    }

    /**
     * Set lostHP
     *
     * @param string $lostHP
     * @return Character
     */
    public function setLostHP($lostHP)
    {
        $this->lostHP = $lostHP;

        return $this;
    }

    /**
     * Get currentHP
     *
     * @return string
     */
    public function getLostHP()
    {
        return $this->lostHP;
    }

    /**
     * Set favoredClass
     *
     * @param ClassDefinition $favoredClass
     * @return Character
     */
    public function setFavoredClass(ClassDefinition $favoredClass)
    {
        $this->favoredClass = $favoredClass;

        return $this;
    }

    /**
     * Get favoredClass
     *
     * @return ClassDefinition
     */
    public function getFavoredClass()
    {
        return $this->favoredClass;
    }

    public function getMaxHp()
    {
        $hp = 0;
        foreach ($this->getLevels() as $level) {
            $hp += $level->getHpRoll() + $level->getExtraHp();
        }

        return $hp;
    }

    /**
     * Set baseStrength
     *
     * @param integer $baseStrength
     * @return Character
     */
    public function setBaseStrength($baseStrength)
    {
        $this->baseStrength = $baseStrength;

        return $this;
    }

    /**
     * Get baseStrength
     *
     * @return integer
     */
    public function getBaseStrength()
    {
        return $this->baseStrength;
    }

    /**
     * Set baseDexterity
     *
     * @param integer $baseDexterity
     * @return Character
     */
    public function setBaseDexterity($baseDexterity)
    {
        $this->baseDexterity = $baseDexterity;

        return $this;
    }

    /**
     * Get baseDexterity
     *
     * @return integer
     */
    public function getBaseDexterity()
    {
        return $this->baseDexterity;
    }

    /**
     * Set baseConstitution
     *
     * @param integer $baseConstitution
     * @return Character
     */
    public function setBaseConstitution($baseConstitution)
    {
        $this->baseConstitution = $baseConstitution;

        return $this;
    }

    /**
     * Get baseConstitution
     *
     * @return integer
     */
    public function getBaseConstitution()
    {
        return $this->baseConstitution;
    }

    /**
     * Set baseIntelligence
     *
     * @param integer $baseIntelligence
     * @return Character
     */
    public function setBaseIntelligence($baseIntelligence)
    {
        $this->baseIntelligence = $baseIntelligence;

        return $this;
    }

    /**
     * Get baseIntelligence
     *
     * @return integer
     */
    public function getBaseIntelligence()
    {
        return $this->baseIntelligence;
    }

    /**
     * Set baseWisdom
     *
     * @param integer $baseWisdom
     * @return Character
     */
    public function setBaseWisdom($baseWisdom)
    {
        $this->baseWisdom = $baseWisdom;

        return $this;
    }

    /**
     * Get baseWisdom
     *
     * @return integer
     */
    public function getBaseWisdom()
    {
        return $this->baseWisdom;
    }

    /**
     * Set baseCharisma
     *
     * @param integer $baseCharisma
     * @return Character
     */
    public function setBaseCharisma($baseCharisma)
    {
        $this->baseCharisma = $baseCharisma;

        return $this;
    }

    /**
     * Get baseCharisma
     *
     * @return integer
     */
    public function getBaseCharisma()
    {
        return $this->baseCharisma;
    }

    /**
     * Get strength
     *
     * @return integer
     */
    public function getStrength()
    {
        $racialBonus = 0;
        if (array_key_exists("strength", $this->getRace()->getModifiers())) {
            $racialBonus = $this->getRace()->getModifiers()["strength"];
        }
        $levelBonus = 0;
        foreach ($this->getLevels() as $level) {
            if (array_key_exists("strength", $level->getModifiers())) {
                $levelBonus += $level->getModifiers()["strength"];
            }
        }

        return $this->getBaseStrength() + $racialBonus + $levelBonus;
    }

    /**
     * Get dexterity
     *
     * @return integer
     */
    public function getDexterity()
    {
        $racialBonus = 0;
        if (array_key_exists("dexterity", $this->getRace()->getModifiers())) {
            $racialBonus = $this->getRace()->getModifiers()["dexterity"];
        }
        $levelBonus = 0;
        foreach ($this->getLevels() as $level) {
            if (array_key_exists("dexterity", $level->getModifiers())) {
                $levelBonus += $level->getModifiers()["dexterity"];
            }
        }

        return $this->getBaseDexterity() + $racialBonus + $levelBonus;
    }

    /**
     * Get constitution
     *
     * @return integer
     */
    public function getConstitution()
    {
        $racialBonus = 0;
        if (array_key_exists("constitution", $this->getRace()->getModifiers())) {
            $racialBonus = $this->getRace()->getModifiers()["constitution"];
        }
        $levelBonus = 0;
        foreach ($this->getLevels() as $level) {
            if (array_key_exists("constitution", $level->getModifiers())) {
                $levelBonus += $level->getModifiers()["constitution"];
            }
        }

        return $this->getBaseConstitution() + $racialBonus + $levelBonus;
    }

    /**
     * Get intelligence
     *
     * @return integer
     */
    public function getIntelligence()
    {
        $racialBonus = 0;
        if (array_key_exists("intelligence", $this->getRace()->getModifiers())) {
            $racialBonus = $this->getRace()->getModifiers()["intelligence"];
        }
        $levelBonus = 0;
        foreach ($this->getLevels() as $level) {
            if (array_key_exists("intelligence", $level->getModifiers())) {
                $levelBonus += $level->getModifiers()["intelligence"];
            }
        }

        return $this->getBaseIntelligence() + $racialBonus + $levelBonus;
    }

    /**
     * Get wisdom
     *
     * @return integer
     */
    public function getWisdom()
    {
        $racialBonus = 0;
        if (array_key_exists("wisdom", $this->getRace()->getModifiers())) {
            $racialBonus = $this->getRace()->getModifiers()["wisdom"];
        }
        $levelBonus = 0;
        foreach ($this->getLevels() as $level) {
            if (array_key_exists("wisdom", $level->getModifiers())) {
                $levelBonus += $level->getModifiers()["wisdom"];
            }
        }

        return $this->getBaseWisdom() + $racialBonus + $levelBonus;
    }

    /**
     * Get charisma
     *
     * @return integer
     */
    public function getCharisma()
    {
        $racialBonus = 0;
        if (array_key_exists("charisma", $this->getRace()->getModifiers())) {
            $racialBonus = $this->getRace()->getModifiers()["charisma"];
        }
        $levelBonus = 0;
        foreach ($this->getLevels() as $level) {
            if (array_key_exists("charisma", $level->getModifiers())) {
                $levelBonus += $level->getModifiers()["charisma"];
            }
        }

        return $this->getBaseCharisma() + $racialBonus + $levelBonus;
    }

    public function getAbilityModifier($value)
    {
        return (int)(($value - ($value % 2) - 10) / 2);
    }

    /**
     * @return Level[]
     */
    private function getMaxLevelPerClass()
    {
        /** @var $max Level[] */
        $max = array();
        foreach ($this->getLevels() as $level) {
            if (!array_key_exists($level->getClassDefinition()->getId(), $max)
                || $level->getLevel() > $max[$level->getClassDefinition()->getId()]->getLevel()
            ) {
                $max[$level->getClassDefinition()->getId()] = $level;
            }
        }

        return $max;
    }

    public function getBab()
    {
        $bab = 0;
        foreach ($this->getMaxLevelPerClass() as $level) {
            $bab += $level->getClassDefinition()->getBab()[$level->getLevel() - 1];
        }

        return $bab;
    }

    public function getBaseReflexes()
    {
        $reflexes = 0;
        foreach ($this->getMaxLevelPerClass() as $level) {
            $reflexes += $level->getClassDefinition()->getReflexes()[$level->getLevel() - 1];
        }

        return $reflexes;
    }

    public function getReflexes()
    {
        $reflexes = $this->getBaseReflexes() + $this->getAbilityModifier($this->getDexterity());

        $language = new ExpressionLanguage();
        foreach ($this->getFeats() as $feat) {
            if (!$feat->isActive()) {
                continue;
            }

            if (array_key_exists("reflexes", $feat->getFeat()->getEffect())) {
                $bonus = (int)$language->evaluate(
                    $feat->getFeat()->getEffect()["reflexes"],
                    array("c" => $this)
                );
                $reflexes += $bonus;
            }
        }

        return $reflexes;
    }

    public function getBaseFortitude()
    {
        $fortitude = 0;
        foreach ($this->getMaxLevelPerClass() as $level) {
            $fortitude += $level->getClassDefinition()->getFortitude()[$level->getLevel() - 1];
        }

        return $fortitude;
    }

    public function getFortitude()
    {
        $fortitude = $this->getBaseFortitude() + $this->getAbilityModifier($this->getConstitution());

        $language = new ExpressionLanguage();
        foreach ($this->getFeats() as $feat) {
            if (!$feat->isActive()) {
                continue;
            }

            if (array_key_exists("fortitude", $feat->getFeat()->getEffect())) {
                $bonus = (int)$language->evaluate(
                    $feat->getFeat()->getEffect()["fortitude"],
                    array("c" => $this)
                );
                $fortitude += $bonus;
            }
        }

        return $fortitude;
    }

    public function getBaseWill()
    {
        $will = 0;
        foreach ($this->getMaxLevelPerClass() as $level) {
            $will += $level->getClassDefinition()->getWill()[$level->getLevel() - 1];
        }

        return $will;
    }

    public function getWill()
    {
        $will = $this->getBaseWill() + $this->getAbilityModifier($this->getWisdom());

        $language = new ExpressionLanguage();
        foreach ($this->getFeats() as $feat) {
            if (!$feat->isActive()) {
                continue;
            }

            if (array_key_exists("will", $feat->getFeat()->getEffect())) {
                $bonus = (int)$language->evaluate(
                    $feat->getFeat()->getEffect()["will"],
                    array("c" => $this)
                );
                $will += $bonus;
            }
        }

        return $will;
    }

    private function getAttackRoll($type, $modifier)
    {
        $language = new ExpressionLanguage();
        $bab = $this->getBab();
        $ar = $bab + $modifier;
        $bonusAttacks = 0;
        foreach ($this->getFeats() as $feat) {
            if (!$feat->isActive() || ($feat->getFeat()->getWorksIf() && !in_array(
                        $type,
                        $feat->getFeat()->getWorksIf()
                    ))
            ) {
                continue;
            }

            if (array_key_exists("attack-roll", $feat->getFeat()->getEffect())) {
                $bonus = (int)$language->evaluate(
                    $feat->getFeat()->getEffect()["attack-roll"],
                    array("c" => $this)
                );
                $ar += $bonus;
            }
            if (array_key_exists('attacks', $feat->getFeat()->getEffect())) {
                $bonusAttacks += $feat->getFeat()->getEffect()['attacks'];
            }
        }

        $weapon = $this->getLeftWeapon();
        if ($weapon && (
                ($type == 'ranged' && $weapon->getRange() > 0) ||
                ($type == 'melee' && $weapon->getRange() === 0)
            )
        ) {
            $bonus = (int)$language->evaluate(
                $weapon->getEffect()["attack-roll"],
                array("c" => $this)
            );
            $ar += $bonus;
        }

        $ars = array();
        for ($bonusAttacks; $bonusAttacks > 0; $bonusAttacks--) {
            $ars[] = $ar;
        }
        for ($bab; $bab >= 0; $bab -= 5) {
            $ars[] = $ar;
            $ar -= 5;
        }

        return $ars;
    }

    public function getMeleeAttackRoll()
    {
        return $this->getAttackRoll("melee", $this->getAbilityModifier($this->getStrength()));
    }

    public function getRangedAttackRoll()
    {
        return $this->getAttackRoll("ranged", $this->getAbilityModifier($this->getDexterity()));
    }

    public function getDamageRoll($type, $modifier)
    {
        $language = new ExpressionLanguage();
        $drb = $modifier;

        foreach ($this->getFeats() as $feat) {
            if (!$feat->isActive() || ($feat->getFeat()->getWorksIf() && !in_array(
                        $type,
                        $feat->getFeat()->getWorksIf()
                    ))
            ) {
                continue;
            }

            if (array_key_exists("damage-roll", $feat->getFeat()->getEffect())) {

                $bonus = (int)$language->evaluate(
                    $feat->getFeat()->getEffect()["damage-roll"],
                    array("c" => $this)
                );

                $drb += $bonus;
            }
        }

        $weapon = $this->getLeftWeapon();
        if ($weapon &&
            (
                ($type == 'ranged' && $weapon->getRange() > 0) ||
                ($type == 'melee' && $weapon->getRange() === 0))
        ) {
            $bonus = (int)$language->evaluate(
                $weapon->getEffect()["damage-roll"],
                array("c" => $this)
            );
            $drb += $bonus;
        }

        return $drb;
    }

    public function getMeleeDamageRoll()
    {
        return $this->getDamageRoll("melee", $this->getAbilityModifier($this->getStrength()));
    }

    public function getRangedDamageRoll()
    {
        return $this->getDamageRoll("ranged", 0);
    }

    /**
     * Add feats
     *
     * @param CharacterFeat $feat
     * @return Character
     */
    public function addFeat(CharacterFeat $feat)
    {
        $feat->setCharacter($this);
        $this->feats[] = $feat;

        return $this;
    }

    /**
     * Remove feat
     *
     * @param CharacterFeat $feat
     */
    public function removeFeat(CharacterFeat $feat)
    {
        $this->feats->removeElement($feat);
    }

    /**
     * Get feats
     *
     * @return Collection|CharacterFeat[]
     */
    public function getFeats()
    {
        return $this->feats;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Add inventory
     *
     * @param Item $inventory
     * @return Character
     */
    public function addInventory(Item $inventory)
    {
        $this->inventory[] = $inventory;

        return $this;
    }

    /**
     * Remove inventory
     *
     * @param Item $inventory
     */
    public function removeInventory(Item $inventory)
    {
        $this->inventory->removeElement($inventory);
    }

    /**
     * Get inventory
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     * Set leftWeapon
     *
     * @param Weapon $leftWeapon
     * @return Character
     */
    public function setLeftWeapon(Weapon $leftWeapon = null)
    {
        // Unequip right-hand weapon if this weapon is dual-weilded
        if ($leftWeapon && $leftWeapon->isDualWield()) {
            $this->setRightWeapon(null);
        }
        $this->leftWeapon = $leftWeapon;

        return $this;
    }

    /**
     * Get leftWeapon
     *
     * @return Weapon
     */
    public function getLeftWeapon()
    {
        return $this->leftWeapon;
    }

    /**
     * Set rightHand
     *
     * @param Weapon $rightWeapon
     * @return Character
     */
    public function setRightWeapon(Weapon $rightWeapon = null)
    {
        if ($rightWeapon && $rightWeapon->isDualWield()) {
            $this->setLeftWeapon(null);
        }
        $this->rightFinger = $rightWeapon;

        return $this;
    }

    /**
     * Get rightWeapon
     *
     * @return Weapon
     */
    public function getRightWeapon()
    {
        return $this->rightWeapon;
    }

    /**
     * Set body
     *
     * @param Item $body
     * @return Character
     */
    public function setBody(Item $body = null)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return Item
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set leftFinger
     *
     * @param Item $leftFinger
     * @return Character
     */
    public function setLeftFinger(Item $leftFinger = null)
    {
        $this->leftFinger = $leftFinger;

        return $this;
    }

    /**
     * Get leftFinger
     *
     * @return Item
     */
    public function getLeftFinger()
    {
        return $this->leftFinger;
    }

    /**
     * Set rightFinger
     *
     * @param Item $rightFinger
     * @return Character
     */
    public function setRightFinger(Item $rightFinger = null)
    {
        $this->rightFinger = $rightFinger;

        return $this;
    }

    /**
     * Get rightFinger
     *
     * @return Item
     */
    public function getRightFinger()
    {
        return $this->rightFinger;
    }

    /**
     * Set feet
     *
     * @param Item $feet
     * @return Character
     */
    public function setFeet(Item $feet = null)
    {
        $this->feet = $feet;

        return $this;
    }

    /**
     * Get feet
     *
     * @return Item
     */
    public function getFeet()
    {
        return $this->feet;
    }

    /**
     * Set neck
     *
     * @param Item $neck
     * @return Character
     */
    public function setNeck(Item $neck = null)
    {
        $this->neck = $neck;

        return $this;
    }

    /**
     * Get neck
     *
     * @return Item
     */
    public function getNeck()
    {
        return $this->neck;
    }

    /**
     * Set back
     *
     * @param Item $back
     * @return Character
     */
    public function setBack(Item $back = null)
    {
        $this->back = $back;

        return $this;
    }

    /**
     * Get back
     *
     * @return Item
     */
    public function getBack()
    {
        return $this->back;
    }

    /**
     * Set head
     *
     * @param Item $head
     * @return Character
     */
    public function setHead(Item $head = null)
    {
        $this->head = $head;

        return $this;
    }

    /**
     * Get head
     *
     * @return Item
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * Set belt
     *
     * @param Item $belt
     * @return Character
     */
    public function setBelt(Item $belt = null)
    {
        $this->belt = $belt;

        return $this;
    }

    /**
     * Get belt
     *
     * @return Item
     */
    public function getBelt()
    {
        return $this->belt;
    }

    /**
     * Set hands
     *
     * @param Item $hands
     * @return Character
     */
    public function setHands(Item $hands = null)
    {
        $this->hands = $hands;

        return $this;
    }

    /**
     * Get hands
     *
     * @return Item
     */
    public function getHands()
    {
        return $this->hands;
    }

    /**
     * Set user
     *
     * @param User $user
     * @return Character
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set party
     *
     * @param Party $party
     * @return Character
     */
    public function setParty(Party $party = null)
    {
        $this->party = $party;

        return $this;
    }

    /**
     * Get party
     *
     * @return Party
     */
    public function getParty()
    {
        return $this->party;
    }

    public function getSkillRank(Skill $skill)
    {
        $rank = 0;
        foreach ($this->getLevels() as $level) {
            foreach ($level->getSkills() as $levelSkill) {
                if ($levelSkill->getSkill() === $skill) {
                    $rank += $levelSkill->getValue();
                    break;
                }
            }
        }

        return $rank;
    }

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

    public function hasClassBonus(Skill $skill)
    {
        foreach ($this->getLevels() as $level) {
            if ($level->getClassDefinition()->getClassSkills()->contains($skill)) {
                return true;
            }
        }

        return false;
    }
}

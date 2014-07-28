<?php

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ClassDefinition
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ClassDefinition
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $hpDice;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $skillPoints;

    /**
     * @var integer[]
     *
     * @ORM\Column(type="json_array")
     */
    private $bab;

    /**
     * @var integer[]
     *
     * @ORM\Column(type="json_array")
     */
    private $reflexes;

    /**
     * @var integer[]
     *
     * @ORM\Column(type="json_array")
     */
    private $fortitude;

    /**
     * @var integer[]
     *
     * @ORM\Column(type="json_array")
     */
    private $will;

    /**
     * @var integer[]
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $spellsPerDay;

    /**
     * @var Collection|Skill[]
     *
     * @ORM\ManyToMany(targetEntity="Skill", inversedBy="classes")
     * @ORM\JoinTable(name="class_skills",
     *      joinColumns={@ORM\JoinColumn(name="class_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="skill_id", referencedColumnName="id")}
     *      )
     */
    private $classSkills;

    /**
     * @var array
     *
     * @ORM\Column(name="specials", type="json_array", nullable=true)
     */
    private $specials;

    /**
     * @var Collection|ClassPower[]
     *
     * @ORM\OneToMany(targetEntity="ClassPower", mappedBy="class", cascade={"all"})
     */
    private $powers;

    /**
     * @var string One of intelligence, wisdom or charisma
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Choice(choices={"intelligence", "wisdom", "charisma"})
     */
    private $castingAbility;

    /**
     * @var bool true if this class' spells need to be prepared before being cast
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $preparationNeeded = true;

    /**
     * @var array Number of spells a character of this class knows per level
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $knownSpellsPerLevel;

    /**
     * @var Collection|ClassSpell[]
     *
     * @ORM\OneToMany(targetEntity="ClassSpell", mappedBy="class")
     */
    private $spells;

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
     * Set name
     *
     * @param string $name
     * @return ClassDefinition
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
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set hpDice
     *
     * @param integer $hpDice
     * @return ClassDefinition
     */
    public function setHpDice($hpDice)
    {
        $this->hpDice = $hpDice;

        return $this;
    }

    /**
     * Get hpDice
     *
     * @return integer
     */
    public function getHpDice()
    {
        return $this->hpDice;
    }

    /**
     * Set skillPoints
     *
     * @param integer $skillPoints
     * @return ClassDefinition
     */
    public function setSkillPoints($skillPoints)
    {
        $this->skillPoints = $skillPoints;

        return $this;
    }

    /**
     * Get skillPoints
     *
     * @return integer
     */
    public function getSkillPoints()
    {
        return $this->skillPoints;
    }

    /**
     * Set bab
     *
     * @param array $bab
     * @return ClassDefinition
     */
    public function setBab($bab)
    {
        $this->bab = $bab;

        return $this;
    }

    /**
     * Get bab
     *
     * @return array
     */
    public function getBab()
    {
        return $this->bab;
    }

    /**
     * Set reflexes
     *
     * @param array $reflexes
     * @return ClassDefinition
     */
    public function setReflexes($reflexes)
    {
        $this->reflexes = $reflexes;

        return $this;
    }

    /**
     * Get reflexes
     *
     * @return array
     */
    public function getReflexes()
    {
        return $this->reflexes;
    }

    /**
     * Set fortitude
     *
     * @param array $fortitude
     * @return ClassDefinition
     */
    public function setFortitude($fortitude)
    {
        $this->fortitude = $fortitude;

        return $this;
    }

    /**
     * Get fortitude
     *
     * @return array
     */
    public function getFortitude()
    {
        return $this->fortitude;
    }

    /**
     * Set will
     *
     * @param array $will
     * @return ClassDefinition
     */
    public function setWill($will)
    {
        $this->will = $will;

        return $this;
    }

    /**
     * Get will
     *
     * @return array
     */
    public function getWill()
    {
        return $this->will;
    }

    /**
     * Set spellsPerDay
     *
     * @param array $spellsPerDay
     * @return ClassDefinition
     */
    public function setSpellsPerDay($spellsPerDay)
    {
        $this->spellsPerDay = $spellsPerDay;

        return $this;
    }

    /**
     * Get spellsPerDay
     *
     * @return array
     */
    public function getSpellsPerDay()
    {
        return $this->spellsPerDay;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->classSkills = new ArrayCollection();
    }

    /**
     * Add classSkills
     *
     * @param Skill $classSkills
     * @return ClassDefinition
     */
    public function addClassSkill(Skill $classSkills)
    {
        $this->classSkills[] = $classSkills;

        return $this;
    }

    /**
     * Remove classSkills
     *
     * @param Skill $classSkills
     */
    public function removeClassSkill(Skill $classSkills)
    {
        $this->classSkills->removeElement($classSkills);
    }

    /**
     * Get classSkills
     *
     * @return Collection
     */
    public function getClassSkills()
    {
        return $this->classSkills;
    }

    /**
     * @return array
     */
    public function getSpecials()
    {
        return $this->specials;
    }

    /**
     * @param $specials
     *
     * @return $this
     */
    public function setSpecials($specials)
    {
        $this->specials = $specials;

        return $this;
    }

    /**
     * Add powers
     *
     * @param ClassPower $powers
     *
     * @return ClassDefinition
     */
    public function addPower(ClassPower $powers)
    {
        $this->powers[] = $powers;

        return $this;
    }

    /**
     * Remove powers
     *
     * @param ClassPower $powers
     */
    public function removePower(ClassPower $powers)
    {
        $this->powers->removeElement($powers);
    }

    /**
     * Get powers
     *
     * @return Collection|ClassPower[]
     */
    public function getPowers()
    {
        return $this->powers;
    }

    /**
     * @param string $castingAbility
     *
     * @return $this
     */
    public function setCastingAbility($castingAbility)
    {
        $this->castingAbility = $castingAbility;

        return $this;
    }

    /**
     * @return string
     */
    public function getCastingAbility()
    {
        return $this->castingAbility;
    }

    /**
     * @param boolean $preparationNeeded
     *
     * @return $this
     */
    public function setPreparationNeeded($preparationNeeded)
    {
        $this->preparationNeeded = $preparationNeeded;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isPreparationNeeded()
    {
        return $this->preparationNeeded;
    }

    /**
     * @param array $knownSpellsPerLevel
     *
     * @return $this
     */
    public function setKnownSpellsPerLevel($knownSpellsPerLevel)
    {
        $this->knownSpellsPerLevel = $knownSpellsPerLevel;

        return $this;
    }

    /**
     * @return array
     */
    public function getKnownSpellsPerLevel()
    {
        return $this->knownSpellsPerLevel;
    }

    /**
     * Add spell
     *
     * @param ClassSpell $spell
     *
     * @return ClassDefinition
     */
    public function addSpell(ClassSpell $spell)
    {
        $this->spells[] = $spell;

        return $this;
    }

    /**
     * Remove spell
     *
     * @param ClassSpell $spell
     */
    public function removeSpell(ClassSpell $spell)
    {
        $this->spells->removeElement($spell);
    }

    /**
     * Get spells
     *
     * @return Collection|ClassSpell[]
     */
    public function getSpells()
    {
        return $this->spells;
    }
}

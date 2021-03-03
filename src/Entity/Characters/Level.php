<?php

namespace App\Entity\Characters;

use App\Entity\Rules\ClassDefinition;
use App\Entity\Rules\ClassSpell;
use App\Entity\Rules\SubClass;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Level
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Level
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Character
     *
     * @ORM\ManyToOne(targetEntity=Character::class, inversedBy="levels")
     * @ORM\JoinColumn(name="character", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    protected $character;

    /**
     * @var ClassDefinition
     *
     * @ORM\ManyToOne(targetEntity=ClassDefinition::class)
     * @ORM\JoinColumn(name="class", referencedColumnName="id")
     * @Assert\NotBlank()
     * @ORM\Cache()
     */
    protected $classDefinition;

    /**
     * @var ClassDefinition parent class for prestige classes
     *
     * @ORM\ManyToOne(targetEntity=ClassDefinition::class)
     * @ORM\JoinColumn(name="parent_class", referencedColumnName="id")
     * @ORM\Cache()
     */
    protected $parentClass;

    /**
     * @var Collection|SubClass[]
     *
     * @ORM\ManyToMany(targetEntity=SubClass::class, orphanRemoval=true)
     * @ORM\JoinTable(name="levels_subclasses",
     *      joinColumns={@ORM\JoinColumn(name="level_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="subclass_id", referencedColumnName="id")}
     *      )
     * @ORM\Cache()
     */
    protected $subClasses;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    protected $hpRoll;

    /**
     * Determines whether to add an extra skill point or HP when a favored class is chosen when leveling up
     *
     * @var string[] a combination of 'skill', 'hp', 'spell'
     *
     * @ORM\Column(type="json", nullable=true)
     */
    protected $extraPoint;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $extraAbility;

    /**
     * @var Collection|CharacterFeat[]
     *
     * @ORM\OneToMany(targetEntity=CharacterFeat::class, mappedBy="level", cascade={"all"}, orphanRemoval=true)
     */
    protected $feats;

    /**
     * @var Collection|LevelSkill[]
     *
     * @ORM\OneToMany(targetEntity=LevelSkill::class, mappedBy="level", cascade={"all"}, orphanRemoval=true)
     */
    protected $skills;

    /**
     * @var Collection|CharacterClassPower[]
     *
     * @ORM\OneToMany(targetEntity=CharacterClassPower::class, mappedBy="level", cascade={"all"}, orphanRemoval=true)
     */
    protected $classPowers;

    /**
     * @var Collection|ClassSpell[]
     *
     * @ORM\ManyToMany(targetEntity=ClassSpell::class, orphanRemoval=true)
     * @ORM\JoinTable(name="levels_spells",
     *      joinColumns={@ORM\JoinColumn(name="level_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="classspell_id", referencedColumnName="id")}
     *      )
     */
    protected $learnedSpells;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    protected $value;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subClasses  = new ArrayCollection();
        $this->skills      = new ArrayCollection();
        $this->feats       = new ArrayCollection();
        $this->classPowers = new ArrayCollection();
        $this->learnedSpells = new ArrayCollection();
    }

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
     * Set character
     *
     * @param Character $character
     *
     * @return $this
     */
    public function setCharacter(Character $character)
    {
        $this->character = $character;

        return $this;
    }

    /**
     * Get character
     *
     * @return Character
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * Set classDefinition
     *
     * @param ClassDefinition $classDefinition
     *
     * @return $this
     */
    public function setClassDefinition(ClassDefinition $classDefinition)
    {
        $this->classDefinition = $classDefinition;

        return $this;
    }

    /**
     * Get classDefinition
     *
     * @return ClassDefinition
     */
    public function getClassDefinition()
    {
        return $this->classDefinition;
    }

    /**
     * @return ClassDefinition
     */
    public function getParentClass()
    {
        return $this->parentClass;
    }

    /**
     * @param ClassDefinition $parentClass
     *
     * @return $this
     */
    public function setParentClass(ClassDefinition $parentClass)
    {
        $this->parentClass = $parentClass;

        return $this;
    }

    /**
     * @return Collection|SubClass[]
     */
    public function getSubClasses()
    {
        return $this->subClasses;
    }

    /**
     * @param SubClass $subClass
     *
     * @return $this
     */
    public function addSubClass(SubClass $subClass)
    {
        $this->subClasses[] = $subClass;

        return $this;
    }

    /**
     * @param SubClass $subClass
     *
     * @return $this
     */
    public function removeSubClass(SubClass $subClass)
    {
        $this->subClasses->removeElement($subClass);

        return $this;
    }

    /**
     * Set hpRoll
     *
     * @param integer $hpRoll
     *
     * @return $this
     */
    public function setHpRoll(int $hpRoll)
    {
        $this->hpRoll = $hpRoll;

        return $this;
    }

    /**
     * Get hpRoll
     *
     * @return integer
     */
    public function getHpRoll()
    {
        return $this->hpRoll;
    }

    /**
     * Set extraPoint
     *
     * @param string[] $extraPoint
     *
     * @return $this
     */
    public function setExtraPoint(array $extraPoint)
    {
        $this->extraPoint = $extraPoint;

        return $this;
    }

    /**
     * Get extraPoint
     *
     * @return string[]
     */
    public function getExtraPoint()
    {
        return $this->extraPoint;
    }

    /**
     * Add a skill or its value if this level already has that skill
     *
     * @param LevelSkill $skill
     *
     * @return $this
     */
    public function addSkill(LevelSkill $skill)
    {
        $matchingSkill = null;
        /** @var LevelSkill $ls */
        foreach ($this->getSkills() as $ls) {
            if ($ls->getSkill() === $skill->getSkill()) {
                $matchingSkill = $ls;
                break;
            }
        }

        if ($matchingSkill) {
            $matchingSkill->setValue($matchingSkill->getValue() + $skill->getValue());
        } else {
            $skill->setLevel($this);
            $this->skills[] = $skill;
        }

        return $this;
    }

    /**
     * Remove skills
     *
     * @param LevelSkill $skills
     */
    public function removeSkill(LevelSkill $skills)
    {
        $this->skills->removeElement($skills);
    }

    /**
     * Get skills
     *
     * @return Collection|LevelSkill[]
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * Set extraAbility
     *
     * @param string $extraAbility
     *
     * @return $this
     */
    public function setExtraAbility(string $extraAbility)
    {
        $this->extraAbility = $extraAbility;

        return $this;
    }

    /**
     * Get extraAbility
     *
     * @return string
     */
    public function getExtraAbility()
    {
        return $this->extraAbility;
    }

    /**
     * Add feats
     *
     * @param CharacterFeat|null $feat
     *
     * @return $this
     */
    public function addFeat(CharacterFeat $feat = null)
    {
        $feat->setLevel($this);
        $this->feats[] = $feat;

        return $this;
    }

    /**
     * Remove feat
     *
     * @param CharacterFeat|null $feat
     */
    public function removeFeat(CharacterFeat $feat = null)
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

    /**
     * Whether this level is in the favored class
     *
     * @return bool
     */
    public function isFavoredClass()
    {
        return $this->getClassDefinition() === $this->getCharacter()->getFavoredClass();
    }

    /**
     * Add classPowers
     *
     * @param CharacterClassPower $classPower
     *
     * @return $this
     */
    public function addClassPower(CharacterClassPower $classPower)
    {
        $classPower->setLevel($this);
        $this->classPowers[] = $classPower;

        return $this;
    }

    /**
     * Remove classPowers
     *
     * @param CharacterClassPower $classPower
     */
    public function removeClassPower(CharacterClassPower $classPower)
    {
        $this->classPowers->removeElement($classPower);
    }

    /**
     * Get classPowers
     *
     * @return Collection|CharacterClassPower[]
     */
    public function getClassPowers()
    {
        return $this->classPowers;
    }

    /**
     * Add learnedSpells
     *
     * @param ClassSpell $learnedSpell
     *
     * @return $this
     */
    public function addLearnedSpell(ClassSpell $learnedSpell)
    {
        $this->learnedSpells[] = $learnedSpell;

        return $this;
    }

    /**
     * Remove learnedSpell
     *
     * @param ClassSpell $learnedSpell
     */
    public function removeLearnedSpell(ClassSpell $learnedSpell)
    {
        $this->learnedSpells->removeElement($learnedSpell);
    }

    /**
     * Get learnedSpells
     *
     * @return Collection|ClassSpell[]
     */
    public function getLearnedSpells()
    {
        return $this->learnedSpells;
    }

    /**
     * @param Collection|ClassSpell[] $learnedSpells
     *
     * @return $this
     */
    public function setLearnedSpells(Collection $learnedSpells)
    {
        $this->learnedSpells = $learnedSpells;

        return $this;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setValue(int $value)
    {
        $this->value = $value;

        return $this;
    }
}

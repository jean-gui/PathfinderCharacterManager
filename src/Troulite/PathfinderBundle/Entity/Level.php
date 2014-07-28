<?php

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Level
 *
 * @ORM\Table()
 * @ORM\Entity
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
    private $id;

    /**
     * @var Character
     *
     * @ORM\ManyToOne(targetEntity="Character", inversedBy="levels")
     * @ORM\JoinColumn(name="character", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $character;

    /**
     * @var Character
     *
     * @ORM\ManyToOne(targetEntity="ClassDefinition")
     * @ORM\JoinColumn(name="class", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $classDefinition;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $hpRoll;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $extraAbility;

    /**
     * @var Collection|CharacterFeat[]
     *
     * @ORM\OneToMany(targetEntity="CharacterFeat", mappedBy="level", cascade={"all"})
     */
    private $feats;

    /**
     * @var Collection|LevelSkill[]
     *
     * @ORM\OneToMany(targetEntity="LevelSkill", mappedBy="level", cascade={"all"})
     */
    private $skills;

    /**
     * @var Collection|CharacterClassPower[]
     *
     * @ORM\OneToMany(targetEntity="CharacterClassPower", mappedBy="level", cascade={"all"})
     */
    private $classPowers;

    /**
     * @var Collection|Spell[]
     *
     * @ORM\ManyToMany(targetEntity="Spell")
     * @ORM\JoinTable(name="levels_spells",
     *      joinColumns={@ORM\JoinColumn(name="level_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="spell_id", referencedColumnName="id")}
     *      )
     */
    private $learnedSpells;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->skills      = new ArrayCollection();
        $this->feats       = new ArrayCollection();
        $this->classPowers = new ArrayCollection();
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
     * Set hpRoll
     *
     * @param integer $hpRoll
     *
     * @return $this
     */
    public function setHpRoll($hpRoll)
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
     * Add a skill or its value if this level already has that skill
     *
     * @param LevelSkill $skill
     *
     * @return $this
     */
    public function addSkill(LevelSkill $skill)
    {
        $matchingSkill = null;
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
     * @return $this
     */
    public function setExtraAbility($extraAbility)
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
     * @param CharacterFeat $feat
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
     * @param CharacterFeat $feat
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
     * @param Spell $learnedSpell
     * 
     * @return $this
     */
    public function addLearnedSpell(Spell $learnedSpell)
    {
        $this->learnedSpells[] = $learnedSpell;

        return $this;
    }

    /**
     * Remove learnedSpell
     *
     * @param Spell $learnedSpell
     */
    public function removeLearnedSpell(Spell $learnedSpell)
    {
        $this->learnedSpells->removeElement($learnedSpell);
    }

    /**
     * Get learnedSpells
     *
     * @return Collection|Spell[] 
     */
    public function getLearnedSpells()
    {
        return $this->learnedSpells;
    }
}

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
     * @var BaseCharacter
     *
     * @ORM\ManyToOne(targetEntity="BaseCharacter", inversedBy="levels")
     * @ORM\JoinColumn(name="character", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $character;

    /**
     * @var BaseCharacter
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
     * @ORM\OneToMany(targetEntity="LevelSkill", mappedBy="level")
     */
    private $skills;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->skills = new ArrayCollection();
        $this->feats  = new ArrayCollection();
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
     * @param BaseCharacter $character
     *
     * @return Level
     */
    public function setCharacter(BaseCharacter $character)
    {
        $this->character = $character;

        return $this;
    }

    /**
     * Get character
     *
     * @return BaseCharacter
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
     * @return Level
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
     * @return Level
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
     * Add skills
     *
     * @param LevelSkill $skill
     *
     * @return Level
     */
    public function addSkill(LevelSkill $skill)
    {
        $skill->setLevel($this);
        $this->skills[] = $skill;

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
     * @return Level
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
     * @return BaseCharacter
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
}

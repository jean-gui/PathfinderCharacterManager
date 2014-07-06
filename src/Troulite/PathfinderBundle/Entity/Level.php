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
     * @ORM\Column(name="level", type="integer")
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 1,
     *      max = 20,
     *      minMessage = "Characters must be at least level 1",
     *      maxMessage = "Maximum level of a character is 20"
     * )
     */
    private $level;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $hpRoll;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $extraHp = 0;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $extraSkill = 0;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $modifiers;

    /**
     * @var Collection|LevelSkill[]
     *
     * @ORM\OneToMany(targetEntity="LevelSkill", mappedBy="level")
     */
    private $skills;

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
     * Set level
     *
     * @param integer $level
     *
     * @return Level
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
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
     * Set extraHp
     *
     * @param integer $extraHp
     *
     * @return Level
     */
    public function setExtraHp($extraHp)
    {
        $this->extraHp = $extraHp;

        return $this;
    }

    /**
     * Get extraHp
     *
     * @return integer
     */
    public function getExtraHp()
    {
        return $this->extraHp;
    }

    /**
     * Set extraSkill
     *
     * @param integer $extraSkill
     *
     * @return Level
     */
    public function setExtraSkill($extraSkill)
    {
        $this->extraSkill = $extraSkill;

        return $this;
    }

    /**
     * Get extraSkill
     *
     * @return integer
     */
    public function getExtraSkill()
    {
        return $this->extraSkill;
    }

    /**
     * Set modifiers
     *
     * @param array $modifiers
     *
     * @return Level
     */
    public function setModifiers($modifiers)
    {
        $this->modifiers = $modifiers;

        return $this;
    }

    /**
     * Get modifiers
     *
     * @return array
     */
    public function getModifiers()
    {
        return $this->modifiers;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->skills = new ArrayCollection();
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
}

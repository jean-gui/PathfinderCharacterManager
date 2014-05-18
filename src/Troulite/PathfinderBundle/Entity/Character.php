<?php

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var \Doctrine\Common\Collections\Collection|Level[]
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
     * @return \Doctrine\Common\Collections\Collection|Level[]
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
        $max = array();
        foreach ($this->getLevels() as $level) {
            if ($level->getLevel() > $max[$level->getClassDefinition()->getId()]) {
                $max[$level->getClassDefinition()->getId()] = $level;
            }
        }

        return $max;
    }

    public function getBba()
    {
        $bba = 0;
        foreach ($this->getMaxLevelPerClass() as $level) {
            $bba += $level->getClassDefinition()->getBba()[$level->getLevel() - 1];
        }

        return $bba;
    }
}

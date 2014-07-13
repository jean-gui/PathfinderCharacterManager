<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 12/07/14
 * Time: 16:16
 */

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Abilities
 *
 * @package Troulite\PathfinderBundle\Entity
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Abilities
{
    const STRENGTH     = 'strength';
    const DEXTERITY    = 'dexterity';
    const CONSTITUTION = 'constitution';
    const INTELLIGENCE = 'intelligence';
    const WISDOM       = 'wisdom';
    const CHARISMA     = 'charisma';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * @var int
     */
    private $strengthBonus = 0;
    /**
     * @var int
     */
    private $dexterityBonus = 0;
    /**
     * @var int
     */
    private $constitutionBonus = 0;
    /**
     * @var int
     */
    private $intelligenceBonus = 0;
    /**
     * @var int
     */
    private $wisdomBonus = 0;
    /**
     * @var int
     */
    private $charismaBonus = 0;

    /**
     * @param $strength
     * @param $dexterity
     * @param $constitution
     * @param $intelligence
     * @param $wisdom
     * @param $charisma
     */
    public function __construct(
        $strength = 10,
        $dexterity = 10,
        $constitution = 10,
        $intelligence = 10,
        $wisdom = 10,
        $charisma = 10)
    {
        $this->baseStrength     = $strength;
        $this->baseDexterity    = $dexterity;
        $this->baseConstitution = $constitution;
        $this->baseIntelligence = $intelligence;
        $this->baseWisdom       = $wisdom;
        $this->baseCharisma     = $charisma;
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
     * Get strength
     *
     * @return integer
     */
    public function getBaseStrength()
    {
        return $this->baseStrength;
    }

    /**
     * Set strength
     *
     * @param integer $baseStrength
     *
     * @return BaseCharacter
     */
    public function setBaseStrength($baseStrength)
    {
        $this->baseStrength = $baseStrength;

        return $this;
    }

    /**
     * Get dexterity
     *
     * @return integer
     */
    public function getBaseDexterity()
    {
        return $this->baseDexterity;
    }

    /**
     * Set dexterity
     *
     * @param integer $baseDexterity
     *
     * @return BaseCharacter
     */
    public function setBaseDexterity($baseDexterity)
    {
        $this->baseDexterity = $baseDexterity;

        return $this;
    }

    /**
     * Get constitution
     *
     * @return integer
     */
    public function getBaseConstitution()
    {
        return $this->baseConstitution;
    }

    /**
     * Set constitution
     *
     * @param integer $baseConstitution
     *
     * @return BaseCharacter
     */
    public function setBaseConstitution($baseConstitution)
    {
        $this->baseConstitution = $baseConstitution;

        return $this;
    }

    /**
     * Get intelligence
     *
     * @return integer
     */
    public function getBaseIntelligence()
    {
        return $this->baseIntelligence;
    }

    /**
     * Set intelligence
     *
     * @param integer $baseIntelligence
     *
     * @return BaseCharacter
     */
    public function setBaseIntelligence($baseIntelligence)
    {
        $this->baseIntelligence = $baseIntelligence;

        return $this;
    }

    /**
     * Get wisdom
     *
     * @return integer
     */
    public function getBaseWisdom()
    {
        return $this->baseWisdom;
    }

    /**
     * Set wisdom
     *
     * @param integer $baseWisdom
     *
     * @return BaseCharacter
     */
    public function setBaseWisdom($baseWisdom)
    {
        $this->baseWisdom = $baseWisdom;

        return $this;
    }

    /**
     * Get charisma
     *
     * @return integer
     */
    public function getBaseCharisma()
    {
        return $this->baseCharisma;
    }

    /**
     * Set charisma
     *
     * @param integer $baseCharisma
     *
     * @return BaseCharacter
     */
    public function setBaseCharisma($baseCharisma)
    {
        $this->baseCharisma = $baseCharisma;

        return $this;
    }

    /**
     * @param int $strengthBonus
     */
    public function setStrengthBonus($strengthBonus)
    {
        $this->strengthBonus = $strengthBonus;
    }

    /**
     * @return int
     */
    public function getStrengthBonus()
    {
        return $this->strengthBonus;
    }

    /**
     * @param int $dexterityBonus
     */
    public function setDexterityBonus($dexterityBonus)
    {
        $this->dexterityBonus = $dexterityBonus;
    }

    /**
     * @return int
     */
    public function getDexterityBonus()
    {
        return $this->dexterityBonus;
    }

    /**
     * @param int $constitutionBonus
     */
    public function setConstitutionBonus($constitutionBonus)
    {
        $this->constitutionBonus = $constitutionBonus;
    }

    /**
     * @return int
     */
    public function getConstitutionBonus()
    {
        return $this->constitutionBonus;
    }

    /**
     * @param int $intelligenceBonus
     */
    public function setIntelligenceBonus($intelligenceBonus)
    {
        $this->intelligenceBonus = $intelligenceBonus;
    }

    /**
     * @return int
     */
    public function getIntelligenceBonus()
    {
        return $this->intelligenceBonus;
    }

    /**
     * @param int $wisdomBonus
     */
    public function setWisdomBonus($wisdomBonus)
    {
        $this->wisdomBonus = $wisdomBonus;
    }

    /**
     * @return int
     */
    public function getWisdomBonus()
    {
        return $this->wisdomBonus;
    }

    /**
     * @param int $charismaBonus
     */
    public function setCharismaBonus($charismaBonus)
    {
        $this->charismaBonus = $charismaBonus;
    }

    /**
     * @return int
     */
    public function getCharismaBonus()
    {
        return $this->charismaBonus;
    }
}

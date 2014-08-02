<?php

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PreparedSpell
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class PreparedSpell
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
     * @ORM\ManyToOne(targetEntity="Character", inversedBy="preparedSpells")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $character;

    /**
     * @var Spell
     *
     * @ORM\ManyToOne(targetEntity="Spell")
     * @ORM\JoinColumn(name="spell_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $spell;

    /**
     * @var ClassDefinition Class this spell is prepared as
     *
     * @ORM\ManyToOne(targetEntity="ClassDefinition")
     * @ORM\JoinColumn(name="class_id", referencedColumnName="id")
     */
    private $class;

    /**
     * @var int Number of times the spell has been memorized
     *
     * @ORM\Column(type="integer")
     */
    private $count = 1;

    /**
     * @var int Number of times the spell has been cast
     *
     * @ORM\Column(type="integer")
     */
    private $castCount = 0;

    /**
     * @param Character $character
     * @param Spell $spell
     * @param ClassDefinition $class
     * @param int $count
     * @param int $castCount
     */
    public function __construct(Character $character = null, Spell $spell, ClassDefinition $class, $count = 1, $castCount = 0)
    {
        $this->character = $character;
        $this->spell = $spell;
        $this->class = $class;
        $this->count = $count;
        $this->$castCount = $castCount;
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
     * Set count
     *
     * @param integer $count
     * @return $this
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer 
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set castCount
     *
     * @param integer $castCount
     * @return $this
     */
    public function setCastCount($castCount)
    {
        $this->castCount = $castCount;

        return $this;
    }

    /**
     * Get castCount
     *
     * @return integer 
     */
    public function getCastCount()
    {
        return $this->castCount;
    }

    /**
     * Set character
     *
     * @param Character $character
     * 
     * @return $this
     */
    public function setCharacter(Character $character = null)
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
     * Set spell
     *
     * @param Spell $spell
     * 
     * @return $this
     */
    public function setSpell(Spell $spell = null)
    {
        $this->spell = $spell;

        return $this;
    }

    /**
     * Get spell
     *
     * @return Spell 
     */
    public function getSpell()
    {
        return $this->spell;
    }

    /**
     * Set class
     *
     * @param ClassDefinition $class
     *
     * @return $this
     */
    public function setClass(ClassDefinition $class = null)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return ClassDefinition
     */
    public function getClass()
    {
        return $this->class;
    }
}

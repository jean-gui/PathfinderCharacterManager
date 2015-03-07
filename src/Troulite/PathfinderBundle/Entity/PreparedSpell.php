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
     * @var bool Has the spell already been cast today?
     *
     * @ORM\Column(type="boolean")
     */
    private $alreadyCast = false;

    /**
     * @param Character $character
     * @param Spell $spell
     * @param ClassDefinition $class
     * @param bool $alreadyCast
     */
    public function __construct(
        Character $character = null,
        Spell $spell = null,
        ClassDefinition $class = null,
        $alreadyCast = false
    ) {
        $this->character = $character;
        $this->spell = $spell;
        $this->class = $class;
        $this->alreadyCast = $alreadyCast;
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
     * Set castCount
     *
     * @param bool $alreadyCast
     *
     * @return $this
     */
    public function setAlreaydCast($alreadyCast)
    {
        $this->alreadyCast = $alreadyCast;

        return $this;
    }

    /**
     * Get alreadyCast
     *
     * @return integer 
     */
    public function isAlreadyCast()
    {
        return $this->alreadyCast;
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

    /**
     * @return int|null
     */
    public function getSpellLevel()
    {
        if ($this->getSpell()) {
            return $this->getClass()->getClassSpell($this->getSpell())->getSpellLevel();
        }
        return null;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getSpell()->__toString();
    }
}

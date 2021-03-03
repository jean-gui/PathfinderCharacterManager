<?php

namespace App\Entity\Characters;

use App\Entity\PowerInterface;
use App\Entity\Rules\Spell;
use App\Entity\Traits\PowerTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SpellEffect
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SpellEffect implements PowerInterface
{
    use PowerTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Character who cast the spell responsible for this effect
     *
     * @var Character|null The caster or null if it comes from an unknown source
     *
     * @ORM\ManyToOne(targetEntity=Character::class)
     * @ORM\JoinColumn(name="caster_id", referencedColumnName="id", nullable=true)
     */
    protected $caster;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=false)
     */
    protected $casterLevel;

    /**
     * Target character of this spell effect
     *
     * @var Character
     *
     * @ORM\ManyToOne(targetEntity=Character::class, inversedBy="spellEffects")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    protected $character;

    /**
     * Spell that triggered this spell effect
     *
     * @ORM\ManyToOne(targetEntity=Spell::class)
     * @ORM\JoinColumn(name="spell_id", referencedColumnName="id", nullable=false)
     * @ORM\Cache()
     */
    protected $spell;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $active = false;

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
     * @return string
     */
    public function __toString()
    {
        return $this->getSpell()->__toString();
    }

    /**
     * @param mixed $caster
     *
     * @return $this
     */
    public function setCaster($caster)
    {
        $this->caster = $caster;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCaster()
    {
        return $this->caster;
    }

    /**
     * @param int $casterLevel
     *
     * @return $this
     */
    public function setCasterLevel(int $casterLevel)
    {
        $this->casterLevel = $casterLevel;

        return $this;
    }

    /**
     * @return int
     */
    public function getCasterLevel()
    {
        return $this->casterLevel;
    }

    /**
     * @param Spell $spell
     *
     * @return $this
     */
    public function setSpell(Spell $spell)
    {
        $this->spell = $spell;

        return $this;
    }

    public function getSpell()
    {
        return $this->spell;
    }

    /**
     * @param Character|null $character
     *
     * @return $this
     */
    public function setCharacter(Character $character = null)
    {
        $this->character = $character;

        return $this;
    }

    /**
     * @return Character
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return SpellEffect
     */
    public function setActive(bool $active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }
}

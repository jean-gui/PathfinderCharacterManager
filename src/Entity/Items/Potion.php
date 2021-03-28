<?php

namespace App\Entity\Items;

use App\Entity\Rules\ClassDefinition;
use App\Entity\Rules\ClassSpell;
use App\Entity\Rules\Spell;
use App\Entity\Rules\SubClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Potion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var ClassSpell
     * @ORM\ManyToOne(targetEntity=ClassSpell::class)
     * @ORM\JoinColumn(name="classspell_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $classSpell;

    /**
     * @var int
     * @ORM\Column(name="caster_level", nullable=false)
     */
    protected $casterLevel = 1;

    /**
     * @var bool
     * @ORM\Column(name="instantaneous", type="boolean", nullable=false, options={"default": false})
     */
    protected $instantaneous = false;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClassSpell(): ?ClassSpell
    {
        return $this->classSpell;
    }

    public function setClassSpell(ClassSpell $classSpell): self
    {
        $this->classSpell = $classSpell;

        return $this;
    }

    /**
     * @return int
     */
    public function getCasterLevel(): ?int
    {
        return $this->casterLevel;
    }

    /**
     * @param int $casterLevel
     *
     * @return Potion
     */
    public function setCasterLevel(int $casterLevel): self
    {
        $this->casterLevel = $casterLevel;

        return $this;
    }

    public function getSpell(): ?Spell
    {
        if ($this->classSpell) {
            return $this->classSpell->getSpell();
        }

        return null;
    }

    public function getClass(): ?ClassDefinition
    {
        if ($this->classSpell) {
            return $this->classSpell->getClass();
        }

        return null;
    }

    public function getSubClass(): ?SubClass
    {
        if ($this->classSpell) {
            return $this->classSpell->getSubClass();
        }

        return null;
    }

    public function getSpellLevel(): ?int
    {
        if ($this->classSpell) {
            return $this->classSpell->getSpellLevel();
        }

        return null;
    }

    /**
     * @return bool
     */
    public function isInstantaneous(): bool
    {
        return $this->instantaneous;
    }

    /**
     * @param bool $instantaneous
     *
     * @return Potion
     */
    public function setInstantaneous(bool $instantaneous): self
    {
        $this->instantaneous = $instantaneous;

        return $this;
    }

    public function __toString(): string
    {
        return $this->classSpell->__toString().'';
    }
}

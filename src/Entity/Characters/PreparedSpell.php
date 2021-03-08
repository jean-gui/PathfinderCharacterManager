<?php

namespace App\Entity\Characters;

use App\Entity\Rules\ClassDefinition;
use App\Entity\Rules\ClassSpell;
use App\Entity\Rules\Spell;
use App\Entity\Rules\SubClass;
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
    protected $id;

    /**
     * @var Character
     *
     * @ORM\ManyToOne(targetEntity=Character::class, inversedBy="preparedSpells")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    protected $character;

    /**
     * @var Spell
     *
     * @ORM\ManyToOne(targetEntity=Spell::class)
     * @ORM\JoinColumn(name="spell_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    protected $spell;

    /**
     * @var int slot level (max spell level this slot can be used for)
     *
     * @ORM\Column(name="level", type="integer")
     */
    protected $level;

    /**
     * @var ClassDefinition Class this spell is prepared as
     *
     * @ORM\ManyToOne(targetEntity=ClassDefinition::class)
     * @ORM\JoinColumn(name="class_id", referencedColumnName="id")
     */
    protected $class;

    /**
     * @var bool slot associated with subclass
     *
     * @ORM\Column(name="subclass_slot", type="boolean")
     */
    protected $subClassSlot = false;

    /**
     * @var bool Has the spell already been cast today?
     *
     * @ORM\Column(type="boolean")
     */
    protected $alreadyCast = false;

    public function __construct(
        Character $character = null,
        Spell $spell = null,
        ClassDefinition $class = null,
        $alreadyCast = false,
        $subClassSlot = false,
        $level = null
    ) {
        $this->character = $character;
        $this->spell = $spell;
        $this->class = $class;
        $this->alreadyCast = $alreadyCast;
        $this->subClassSlot = $subClassSlot;
        $this->level = $level;
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
    public function setAlreaydCast(bool $alreadyCast)
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
     * @param Spell|null $spell
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
     * @param ClassDefinition|null $class
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

    public function setSubClassSlot(bool $subClassSlot): self
    {
        $this->subClassSlot = $subClassSlot;

        return $this;
    }

    public function isSubclassSlot(): bool
    {
        return $this->subClassSlot;
    }

    /**
     * @return int|null
     */
    public function getLevel(): ?int
    {
        return $this->level;
    }

    /**
     * @param int|null $level
     *
     * @return PreparedSpell
     */
    public function setLevel(?int $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSpellLevel()
    {
        if ($this->getSpell()) {
            $classSpell = $this->getClass()->getClassSpell($this->getSpell());
            if ($classSpell) {
                return $this->getClass()->getClassSpell($this->getSpell())->getSpellLevel();
            } else {
                /** @var SubClass[] $subClasses */
                $subClasses = $this->getCharacter()->getSubClassesFor($this->getClass());
                foreach ($subClasses as $subClass) {
                    $classSpell = $subClass->getClassSpell($this->getSpell());

                    if ($classSpell && $classSpell->getSpellLevel()) {
                        return $classSpell->getSpellLevel();
                    }
                }
            }
        }

        return null;
    }

    /**
     * @return ClassSpell[][]
     */
    public function getAvailableSpells(): array
    {
        /** @var ClassSpell[] $spells */
        $spells = [];
        if ($this->isSubclassSlot()) {
            foreach ($this->getCharacter()->getSubClassesFor($this->getClass()) as $subclass) {
                $subClassSpells = $subclass->getSpells()->toArray();
                $subClassSpells = array_filter($subClassSpells, function (ClassSpell $classSpell) {
                    return $classSpell->getSpellLevel() <= $this->getLevel();
                });
                $spells = array_merge($spells, $subClassSpells);
            }
        } else {
            if ($this->getClass()->getKnownSpellsPerLevel()) { // character has to learn spells
                $classSpells = $this->getCharacter()->getLearnedSpells();
            } else { // character knows all spells provided by this class
                $classSpells = $this->getClass()->getSpells()->toArray();
            }
            $classSpells = array_filter(
                $classSpells,
                function (ClassSpell $classSpell) {
                    return $classSpell->getSpellLevel() <= $this->getLevel();
                }
            );
            $spells      = array_merge($spells, $classSpells);
        }

        usort($spells, function (ClassSpell $a, ClassSpell $b) {
            if ($a->getSpellLevel() === $b->getSpellLevel()) {
                return strcmp($a->__toString(), $b->__toString());
            }

            return $a->getSpellLevel() > $b->getSpellLevel() ? -1 : 1;
        });

        $res = [];

        foreach ($spells as $spell) {
            $res[$spell->getSpellLevel()][] = $spell->getSpell();
        }

        return $res;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getSpell()->__toString();
    }
}

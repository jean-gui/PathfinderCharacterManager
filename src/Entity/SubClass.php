<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * SubClass
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\Cache()
 */
class SubClass
{

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var ClassDefinition
     *
     * @ORM\ManyToOne(targetEntity="ClassDefinition", inversedBy="subClasses")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=false)
     * @ORM\Cache()
     */
    private $parent;

    /**
     * @var Collection|ClassPower[]
     *
     * @ORM\OneToMany(targetEntity="ClassPower", mappedBy="subClass", cascade={"all"})
     * @ORM\Cache()
     */
    private $powers;

    /**
     * @var int
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default"=false})
     */
    private $extraSpellSlot = false;

    /**
     * @var Collection|ClassSpell[]
     *
     * @ORM\OneToMany(targetEntity="ClassSpell", mappedBy="subClass", orphanRemoval=true, cascade={"all"})
     * @ORM\Cache()
     */
    private $spells;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->powers      = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return SubClass
     */
    public function setName(string $name)
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
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return ClassDefinition
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param ClassDefinition $parent
     *
     * @return $this
     */
    public function setParent(ClassDefinition $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Add powers
     *
     * @param ClassPower $power
     *
     * @return SubClass
     */
    public function addPower(ClassPower $power)
    {
        $this->powers[] = $power;
        $power->setSubClass($this);

        return $this;
    }

    /**
     * Remove powers
     *
     * @param ClassPower $powers
     */
    public function removePower(ClassPower $powers)
    {
        $this->powers->removeElement($powers);
    }

    /**
     * Get powers
     *
     * @param int $level
     *
     * @return Collection|ClassPower[]
     */
    public function getPowers($level = null)
    {
        if ($level) {
            return $this->powers->filter(function (ClassPower $power) use ($level) {
                return $power->getLevel() === $level;
            });
        }

        return $this->powers;
    }

    /**
     * @return bool
     */
    public function getExtraSpellSlot()
    {
        return $this->extraSpellSlot;
    }

    /**
     * @param bool $extraSpellSlot
     *
     * @return $this
     */
    public function setExtraSpellSlot(bool $extraSpellSlot)
    {
        $this->extraSpellSlot = $extraSpellSlot;

        return $this;
    }

    /**
     * Add spell
     *
     * @param ClassSpell $spell
     *
     * @return $this
     */
    public function addSpell(ClassSpell $spell)
    {
        foreach ($this->spells as $classSpell) {
            // If already there, simply change its level
            if ($classSpell->getSpell() === $spell->getSpell()) {
                $classSpell->setSpellLevel($spell->getSpellLevel());

                return $this;
            }
        }

        $this->spells[] = $spell;
        $spell->setSubClass($this);

        return $this;
    }

    /**
     * Remove spell
     *
     * @param ClassSpell $spell
     *
     * @return $this
     */
    public function removeSpell(ClassSpell $spell)
    {
        $this->spells->removeElement($spell);
        return $this;
    }

    /**
     * Get spells
     *
     * @return Collection|ClassSpell[]
     */
    public function getSpells()
    {
        return $this->spells;
    }
}

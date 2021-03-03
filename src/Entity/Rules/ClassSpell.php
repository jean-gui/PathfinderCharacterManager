<?php

namespace App\Entity\Rules;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ClassSpell
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\Repository\ClassSpellRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 */
class ClassSpell
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
     * @var ClassDefinition
     *
     * @ORM\ManyToOne(targetEntity=ClassDefinition::class, inversedBy="spells")
     * @ORM\JoinColumn(name="class_id", referencedColumnName="id")
     * @ORM\Cache()
     */
    protected $class;

    /**
     * @var SubClass
     *
     * @ORM\ManyToOne(targetEntity=SubClass::class, inversedBy="spells")
     * @ORM\JoinColumn(name="subclass_id", referencedColumnName="id")
     * @ORM\Cache()
     */
    protected $subClass;

    /**
     * @var Spell
     *
     * @ORM\ManyToOne(targetEntity=Spell::class, inversedBy="classes")
     * @ORM\JoinColumn(name="spell_id", referencedColumnName="id")
     * @ORM\Cache()
     * @Assert\NotBlank()
     */
    protected $spell;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    protected $spellLevel;


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
     * @param integer $spellLevel
     *
     * @return $this
     */
    public function setSpellLevel(int $spellLevel)
    {
        $this->spellLevel = $spellLevel;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getSpellLevel()
    {
        return $this->spellLevel;
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

    /**
     * @return SubClass
     */
    public function getSubClass()
    {
        return $this->subClass;
    }

    /**
     * @param SubClass|null $subClass
     *
     * @return $this
     */
    public function setSubClass(SubClass $subClass = null)
    {
        $this->subClass = $subClass;
        return $this;
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
     * @return string
     */
    public function __toString()
    {
        return $this->getSpell()->__toString();
    }

    /**
     * If this spell belongs to a subclass, assign it to its parent class as well
     * @todo This prevents using read-only second level cache
     * @ORM\PostLoad()
     */
    public function postLoad()
    {
        if ($this->getSubClass()) {
            $this->setClass($this->getSubClass()->getParent());
        }
    }

    /**
     * If this spell belongs to a subclass, remove its parent class (that was set in postLoad)
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        if ($this->getSubClass() && $this->getClass()) {
            $this->setClass();
        }
    }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Traits\Power;

/**
 * Spell
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Cache()
 */
class Spell
{
    use Power;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $castingTime;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $components;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $range;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $savingThrow;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $spellResistance;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $targets;

    /**
     * @var Collection|ClassSpell[]
     *
     * @ORM\OneToMany(targetEntity="ClassSpell", mappedBy="spell")
     * @ORM\Cache()
     */
    private $classes;

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
     * @param mixed $castingTime
     *
     * @return $this
     */
    public function setCastingTime($castingTime)
    {
        $this->castingTime = $castingTime;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCastingTime()
    {
        return $this->castingTime;
    }

    /**
     * @param mixed $components
     *
     * @return $this
     */
    public function setComponents($components)
    {
        $this->components = $components;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
     * @param mixed $duration
     *
     * @return $this
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $range
     *
     * @return $this
     */
    public function setRange($range)
    {
        $this->range = $range;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * @param mixed $savingThrow
     *
     * @return $this
     */
    public function setSavingThrow($savingThrow)
    {
        $this->savingThrow = $savingThrow;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSavingThrow()
    {
        return $this->savingThrow;
    }

    /**
     * @param mixed $spellResistance
     *
     * @return $this
     */
    public function setSpellResistance($spellResistance)
    {
        $this->spellResistance = $spellResistance;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpellResistance()
    {
        return $this->spellResistance;
    }

    /**
     * @param string $targets
     *
     * @return $this
     */
    public function setTargets(string $targets)
    {
        $this->targets = $targets;

        return $this;
    }

    /**
     * @return string
     */
    public function getTargets()
    {
        return $this->targets;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->classes = new ArrayCollection();
    }

    /**
     * Add class
     *
     * @param ClassSpell $class
     *
     * @return Spell
     */
    public function addClass(ClassSpell $class)
    {
        $this->classes[] = $class;

        return $this;
    }

    /**
     * Remove classes
     *
     * @param ClassSpell $class
     */
    public function removeClass(ClassSpell $class)
    {
        $this->classes->removeElement($class);
    }

    /**
     * Get classes
     *
     * @return Collection|ClassSpell[]
     */
    public function getClasses()
    {
        return $this->classes;
    }
}

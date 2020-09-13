<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Skill
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Cache()
 */
class Skill
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="shortname", type="string", length=255)
     */
    private $shortname;

    /**
     * @var boolean
     *
     * @ORM\Column(name="untrained", type="boolean")
     */
    private $untrained = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="armorCheckPenalty", type="boolean")
     */
    private $armorCheckPenalty = false;

    /**
     * @var string
     *
     * @ORM\Column(name="keyAbility", type="string", length=255)
     */
    private $keyAbility;

    /**
     * @var Collection|ClassDefinition[]
     *
     * @ORM\ManyToMany(targetEntity="ClassDefinition", mappedBy="classSkills")
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
     * Set name
     *
     * @param string $name
     *
     * @return Skill
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
     * Set shortname
     *
     * @param string $shortname
     *
     * @return Skill
     */
    public function setShortname(string $shortname)
    {
        $this->shortname = $shortname;

        return $this;
    }

    /**
     * @return string
     */
    public function getShortname()
    {
        return $this->shortname;
    }

    /**
     * Set untrained
     *
     * @param boolean $untrained
     *
     * @return Skill
     */
    public function setUntrained(bool $untrained)
    {
        $this->untrained = $untrained;

        return $this;
    }

    /**
     * Get untrained
     *
     * @return boolean
     */
    public function getUntrained()
    {
        return $this->untrained;
    }

    /**
     * Set armorCheckPenalty
     *
     * @param boolean $armorCheckPenalty
     *
     * @return Skill
     */
    public function setArmorCheckPenalty(bool $armorCheckPenalty)
    {
        $this->armorCheckPenalty = $armorCheckPenalty;

        return $this;
    }

    /**
     * Get armorCheckPenalty
     *
     * @return boolean
     */
    public function getArmorCheckPenalty()
    {
        return $this->armorCheckPenalty;
    }

    /**
     * Set keyAbility
     *
     * @param string $keyAbility
     *
     * @return Skill
     */
    public function setKeyAbility(string $keyAbility)
    {
        $this->keyAbility = $keyAbility;

        return $this;
    }

    /**
     * Get keyAbility
     *
     * @return string
     */
    public function getKeyAbility()
    {
        return $this->keyAbility;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->classes = new ArrayCollection();
    }

    /**
     * Add classes
     *
     * @param ClassDefinition $classes
     * @return Skill
     */
    public function addClass(ClassDefinition $classes)
    {
        $this->classes[] = $classes;

        return $this;
    }

    /**
     * Remove classes
     *
     * @param ClassDefinition $classes
     */
    public function removeClass(ClassDefinition $classes)
    {
        $this->classes->removeElement($classes);
    }

    /**
     * Get classes
     *
     * @return Collection
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getShortname();
    }
}

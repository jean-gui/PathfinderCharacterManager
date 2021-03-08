<?php

namespace App\Entity\Rules;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Skill
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass=SkillRepository::class)
 */
class Skill implements TranslatableInterface
{
    use TranslatableTrait;

    /**
     * @Assert\Valid
     */
    protected $translations;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="shortname", type="string", length=255)
     */
    protected $shortname;

    /**
     * @var boolean
     *
     * @ORM\Column(name="untrained", type="boolean")
     */
    protected $untrained = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="armorCheckPenalty", type="boolean")
     */
    protected $armorCheckPenalty = false;

    /**
     * @var string
     *
     * @ORM\Column(name="keyAbility", type="string", length=255)
     */
    protected $keyAbility;

    /**
     * @var Collection|ClassDefinition[]
     *
     * @ORM\ManyToMany(targetEntity=ClassDefinition::class, mappedBy="classSkills")
     */
    protected $classes;

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
        return $this->__get('name');
    }

    public function __get($name)
    {
        $method    = 'get' . ucfirst($name);
        $arguments = [];

        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }

    public function __isset($name)
    {
        return in_array($name, ['name']);
    }
}

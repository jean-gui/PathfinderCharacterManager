<?php

namespace App\Entity\Rules;

use App\Entity\PowerInterface;
use App\Entity\Traits\PowerTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ClassPower
 *
 * @ORM\Entity()
 *
 * @package App\Entity
 */
class ClassPower implements PowerInterface, TranslatableInterface
{
    use PowerTrait;
    use TranslatableTrait;

    /**
     * @Assert\Valid
     */
    protected $translations;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var ClassDefinition
     *
     * @ORM\ManyToOne(targetEntity=ClassDefinition::class, inversedBy="powers")
     * @ORM\JoinColumn(name="class_id", referencedColumnName="id", nullable=true)
     */
    protected $class;

    /**
     * @var SubClass
     *
     * @ORM\ManyToOne(targetEntity=SubClass::class, inversedBy="powers")
     * @ORM\JoinColumn(name="subclass_id", referencedColumnName="id", nullable=true)
     */
    protected $subClass;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $level;

    /**
     * @var bool Whether the power acts as a spell and is castable
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $castable = false;

    /**
     * @var ClassPower[]|Collection
     *
     * @ORM\ManyToMany(targetEntity=ClassPower::class, mappedBy="parents", cascade={"all"})
     */
    protected $children;

    /**
     * @var ClassPower[]|Collection
     *
     * @ORM\ManyToMany(targetEntity=ClassPower::class, inversedBy="children", cascade={"all"})
     * @ORM\JoinTable(name="class_power_children",
     *      joinColumns={@ORM\JoinColumn(name="child_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="parent_id", referencedColumnName="id")}
     *      )
     */
    protected $parents;

    public function __construct()
    {
        $this->effects  = [];
        $this->parents  = new ArrayCollection();
        $this->children = new ArrayCollection();
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
     * @param mixed $level
     *
     * @return $this
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param ClassDefinition $class
     *
     * @return $this
     */
    public function setClass(ClassDefinition $class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return ClassDefinition
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param SubClass $subClass
     *
     * @return $this
     */
    public function setSubClass(SubClass $subClass)
    {
        $this->subClass = $subClass;

        return $this;
    }

    /**
     * @return SubClass
     */
    public function getSubClass()
    {
        return $this->subClass;
    }

    /**
     * @param $castable
     *
     * @return $this
     */
    public function setCastable($castable = false)
    {
        $this->castable = $castable;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCastable()
    {
        return $this->castable;
    }

    /**
     * @return Collection|ClassPower[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return ClassPower[]|Collection
     */
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * @param ClassPower $parent
     *
     * @return $this
     */
    public function addParent(ClassPower $parent)
    {
        $this->parents[]    = $parent;
        $parent->children[] = $this;

        return $this;
    }

    /**
     * @param ClassPower $parent
     *
     * @return $this
     */
    public function removeParent(ClassPower $parent)
    {
        $this->parents->remove($parent);
        $parent->children->remove($this);

        return $this;
    }

    public function __get($name)
    {
        $method    = 'get' . ucfirst($name);
        $arguments = [];

        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }

    public function __isset($name)
    {
        return in_array($name, ['name', 'shortDescription', 'longDescription']);
    }

    public function __toString(): string
    {
        return $this->__get('name');
    }
}

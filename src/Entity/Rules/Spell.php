<?php

namespace App\Entity\Rules;

use App\Entity\Traits\PowerTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Spell
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Cache()
 */
class Spell implements TranslatableInterface
{
    use PowerTrait;
    use TranslatableTrait;

    /**
     * @Assert\Valid
     */
    protected $translations;

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
    protected $savingThrow;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $spellResistance;

    /**
     * @var Collection|ClassSpell[]
     *
     * @ORM\OneToMany(targetEntity=ClassSpell::class, mappedBy="spell")
     * @ORM\Cache()
     */
    protected $classes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->classes = new ArrayCollection();
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

    public function __get($name)
    {
        $method    = 'get' . ucfirst($name);
        $arguments = [];

        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }

    public function __isset($name)
    {
        return in_array(
            $name,
            ['name', 'shortDescription', 'longDescription', 'castingTime', 'components', 'range', 'duration', 'targets']
        );
    }

    public function __toString(): string
    {
        return $this->__get('name');
    }
}

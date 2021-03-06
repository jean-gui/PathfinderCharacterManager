<?php

namespace App\Entity\Characters;

use App\Entity\Party;
use App\Entity\Rules\Abilities;
use App\Entity\Rules\ClassDefinition;
use App\Entity\Rules\ClassSpell;
use App\Entity\Rules\Condition;
use App\Entity\Rules\Race;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * BaseCharacter
 *
 * @ORM\MappedSuperclass()
 */
class BaseCharacter
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="characters")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var Race
     *
     * @ORM\ManyToOne(targetEntity=Race::class)
     * @ORM\JoinColumn(name="race_id", referencedColumnName="id")
     * @ORM\Cache()
     * @Assert\NotBlank()
     */
    protected $race;

    /**
     * @var ClassDefinition
     *
     * @ORM\ManyToOne(targetEntity=ClassDefinition::class)
     * @ORM\JoinColumn(name="favoredClass", referencedColumnName="id", nullable=false)
     * @ORM\Cache()
     */
    protected $favoredClass;

    /**
     * @var Abilities
     *
     * @ORM\OneToOne(targetEntity=Abilities::class, cascade={"all"})
     * @ORM\JoinColumn(name="abilities_id", referencedColumnName="id")
     */
    protected $abilities;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    protected $lostHP = 0;

    /**
     * @var CharacterEquipment
     *
     * @ORM\OneToOne(targetEntity=CharacterEquipment::class, inversedBy="character", cascade={"all"})
     * @ORM\JoinColumn(name="equipment_id", referencedColumnName="id")
     */
    protected $equipment;

    /**
     * @var Party
     *
     * @ORM\ManyToOne(targetEntity=Party::class, inversedBy="characters")
     * @ORM\JoinColumn(name="party_id", referencedColumnName="id")
     */
    protected $party;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $generalNotes;
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $powerNotes;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $inventoryNotes;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $spellNotes;

    /**
     * @var Collection|ClassSpell[]
     *
     * @ORM\ManyToMany(targetEntity=ClassSpell::class)
     * @ORM\JoinTable(name="character_spells",
     *      joinColumns={@ORM\JoinColumn(name="character_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="classspell_id", referencedColumnName="id")}
     * )
     */
    protected $extraSpells;

    /**
     * @var Collection|Condition[]
     *
     * @ORM\ManyToMany(targetEntity=Condition::class)
     * @ORM\JoinTable(name="character_conditions",
     *      joinColumns={@ORM\JoinColumn(name="character_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="condition_id", referencedColumnName="id")}
     * )
     */
    protected $conditions;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=7, nullable=false, options={"default": "#1ed760"})
     */
    protected $color;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->abilities   = new Abilities();
        $this->equipment   = new CharacterEquipment();
        $this->extraSpells = new ArrayCollection();
        $this->conditions  = new ArrayCollection();
        $this->color       = '#'.$this->random_color_part().$this->random_color_part().$this->random_color_part();
    }

    private function random_color_part()
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
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
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param UserInterface|null $user
     *
     * @return $this
     */
    public function setUser(UserInterface $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get currentHP
     *
     * @return string
     */
    public function getLostHP()
    {
        return $this->lostHP;
    }

    /**
     * Set lostHP
     *
     * @param string $lostHP
     *
     * @return $this
     */
    public function setLostHP(string $lostHP)
    {
        $this->lostHP = $lostHP;

        return $this;
    }

    /**
     * Get favoredClass
     *
     * @return ClassDefinition
     */
    public function getFavoredClass()
    {
        return $this->favoredClass;
    }

    /**
     * Set favoredClass
     *
     * @param ClassDefinition $favoredClass
     *
     * @return $this
     */
    public function setFavoredClass(ClassDefinition $favoredClass)
    {
        $this->favoredClass = $favoredClass;

        return $this;
    }

    /**
     * Get race
     *
     * @return Race
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * Set race
     *
     * @param Race|null $race
     *
     * @return $this
     */
    public function setRace(Race $race = null)
    {
        $this->race = $race;

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
     * Set name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get party
     *
     * @return Party
     */
    public function getParty()
    {
        return $this->party;
    }

    /**
     * Set party
     *
     * @param Party|null $party
     *
     * @return $this
     */
    public function setParty(Party $party = null)
    {
        $this->party = $party;

        return $this;
    }

    /**
     * Set abilities
     *
     * @param Abilities|null $abilities
     *
     * @return $this
     */
    public function setAbilities(Abilities $abilities = null)
    {
        $this->abilities = $abilities;

        return $this;
    }

    /**
     * Get abilities
     *
     * @return Abilities
     */
    public function getAbilities()
    {
        return $this->abilities;
    }

    /**
     * Set equipment
     *
     * @param CharacterEquipment|null $equipment
     *
     * @return $this
     */
    public function setEquipment(CharacterEquipment $equipment = null)
    {
        $this->equipment = $equipment;

        return $this;
    }

    /**
     * Get equipment
     *
     * @return CharacterEquipment
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * @return string
     */
    public function getGeneralNotes()
    {
        return $this->generalNotes;
    }

    /**
     * @param string|null $generalNotes
     *
     * @return $this
     */
    public function setGeneralNotes(?string $generalNotes)
    {
        $this->generalNotes = $generalNotes;

        return $this;
    }

    /**
     * @return string
     */
    public function getPowerNotes()
    {
        return $this->powerNotes;
    }

    /**
     * @param string|null $powerNotes
     *
     * @return $this
     */
    public function setPowerNotes(?string $powerNotes)
    {
        $this->powerNotes = $powerNotes;

        return $this;
    }

    /**
     * @return string
     */
    public function getInventoryNotes()
    {
        return $this->inventoryNotes;
    }

    /**
     * @param string|null $inventoryNotes
     *
     * @return $this
     */
    public function setInventoryNotes(?string $inventoryNotes)
    {
        $this->inventoryNotes = $inventoryNotes;

        return $this;
    }

    /**
     * @return string
     */
    public function getSpellNotes()
    {
        return $this->spellNotes;
    }

    /**
     * @param string|null $spellNotes
     *
     * @return $this
     */
    public function setSpellNotes(?string $spellNotes)
    {
        $this->spellNotes = $spellNotes;

        return $this;
    }

    /**
     * Add extra spell
     *
     * @param ClassSpell $extraSpell
     *
     * @return $this
     */
    public function addExtraSpell(ClassSpell $extraSpell)
    {
        $this->extraSpells[] = $extraSpell;

        return $this;
    }

    /**
     * Remove extra spell
     *
     * @param ClassSpell $extraSpell
     */
    public function removeExtraSpell(ClassSpell $extraSpell)
    {
        $this->extraSpells->removeElement($extraSpell);
    }

    /**
     * Get extra spells
     *
     * @return Collection|ClassSpell[]
     */
    public function getExtraSpells()
    {
        return $this->extraSpells;
    }

    /**
     * @param Collection|ClassSpell[] $extraSpells
     *
     * @return $this
     */
    public function setExtraSpells(Collection $extraSpells)
    {
        $this->extraSpells = $extraSpells;

        return $this;
    }

    /**
     * @return Collection|Condition[]
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * @param Collection|Condition[] $conditions
     *
     * @return $this
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;

        return $this;
    }

    /**
     * @param Condition $condition
     *
     * @return $this
     */
    public function addCondition(Condition $condition)
    {
        $this->conditions[] = $condition;

        return $this;
    }

    /**
     * @param Condition $condition
     *
     * @return $this
     */
    public function removeCondition(Condition $condition)
    {
        $this->conditions->removeElement($condition);

        return $this;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     *
     * @return BaseCharacter
     */
    public function setColor(string $color): BaseCharacter
    {
        $this->color = $color;

        return $this;
    }
}

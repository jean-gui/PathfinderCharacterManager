<?php

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
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
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="characters")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Race")
     * @ORM\JoinColumn(name="race_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $race;

    /**
     * @var ClassDefinition
     *
     * @ORM\ManyToOne(targetEntity="ClassDefinition")
     * @ORM\JoinColumn(name="favoredClass", referencedColumnName="id", nullable=false)
     */
    private $favoredClass;

    /**
     * @var Abilities
     *
     * @ORM\OneToOne(targetEntity="Abilities", cascade={"all"})
     * @ORM\JoinColumn(name="abilities_id", referencedColumnName="id")
     */
    private $abilities;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $lostHP = 0;

    /**
     * @var CharacterEquipment
     *
     * @ORM\OneToOne(targetEntity="CharacterEquipment", inversedBy="character", cascade={"all"})
     * @ORM\JoinColumn(name="equipment_id", referencedColumnName="id")
     */
    private $equipment;

    /**
     * @var Party
     *
     * @ORM\ManyToOne(targetEntity="Party", inversedBy="characters")
     * @ORM\JoinColumn(name="party_id", referencedColumnName="id")
     */
    private $party;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->abilities = new Abilities();
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
     * @param User $user
     *
     * @return $this
     */
    public function setUser(User $user = null)
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
    public function setLostHP($lostHP)
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
     * @param Race $race
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
    public function setName($name)
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
     * @param Party $party
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
     * @param Abilities $abilities
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
     * @param CharacterEquipment $equipment
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
}

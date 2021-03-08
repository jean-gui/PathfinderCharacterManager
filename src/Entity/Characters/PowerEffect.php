<?php

namespace App\Entity\Characters;

use App\Entity\PowerInterface;
use App\Entity\Rules\ClassPower;
use App\Entity\Traits\PowerTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PowerEffect
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class PowerEffect implements PowerInterface
{
    use PowerTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Character who cast the power responsible for this effect
     *
     * @var Character|null The caster or null if it comes from an unknown source
     *
     * @ORM\ManyToOne(targetEntity=Character::class)
     * @ORM\JoinColumn(name="caster_id", referencedColumnName="id", nullable=true)
     */
    protected $caster;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=false)
     */
    protected $casterLevel;

    /**
     * Target character of this power effect
     *
     * @var Character
     *
     * @ORM\ManyToOne(targetEntity=Character::class, inversedBy="powerEffects")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    protected $character;

    /**
     * PowerTrait that triggered this power effect
     *
     * @ORM\ManyToOne(targetEntity=ClassPower::class)
     * @ORM\JoinColumn(name="power_id", referencedColumnName="id", nullable=false)
     */
    protected $power;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $active = false;

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
        return $this->getPower()->__toString();
    }

    /**
     * @param mixed $caster
     *
     * @return $this
     */
    public function setCaster($caster)
    {
        $this->caster = $caster;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCaster()
    {
        return $this->caster;
    }

    /**
     * @param int $casterLevel
     *
     * @return $this
     */
    public function setCasterLevel(int $casterLevel)
    {
        $this->casterLevel = $casterLevel;

        return $this;
    }

    /**
     * @return int
     */
    public function getCasterLevel()
    {
        return $this->casterLevel;
    }

    /**
     * @param ClassPower $power
     *
     * @return $this
     */
    public function setPower(ClassPower $power)
    {
        $this->power = $power;

        return $this;
    }

    public function getPower()
    {
        return $this->power;
    }

    /**
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
     * @return Character
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return PowerEffect
     */
    public function setActive(bool $active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }
}

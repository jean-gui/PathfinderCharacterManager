<?php

namespace App\Entity\Characters;

use App\Entity\Items\Potion;
use App\Entity\Rules\Spell;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="potion_effects")
 * @ORM\Entity
 */
class PotionEffect
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Potion that triggered this effect
     *
     * @ORM\ManyToOne(targetEntity=Potion::class)
     * @ORM\JoinColumn(name="potion_id", referencedColumnName="id", nullable=false)
     */
    protected $potion;

    /**
     * Character who drank the potion
     *
     * @var Character
     *
     * @ORM\ManyToOne(targetEntity=Character::class, inversedBy="potionEffects")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    protected $character;

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
        return $this->getPotion()->__toString();
    }

    public function getPotion(): Potion
    {
        return $this->potion;
    }

    /**
     * @param Potion $potion
     *
     * @return $this
     */
    public function setPotion(Potion $potion): self
    {
        $this->potion = $potion;

        return $this;
    }

    /**
     * @return Character
     */
    public function getCharacter(): Character
    {
        return $this->character;
    }

    /**
     * @param Character|null $character
     *
     * @return $this
     */
    public function setCharacter(Character $character = null): self
    {
        $this->character = $character;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return PotionEffect
     */
    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}

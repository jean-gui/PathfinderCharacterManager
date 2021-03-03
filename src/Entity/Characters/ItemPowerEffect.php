<?php

namespace App\Entity\Characters;

use App\Entity\Items\ItemPower;
use App\Entity\PowerInterface;
use App\Entity\Traits\PowerTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ItemPowerEffect
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Cache()
 */
class ItemPowerEffect implements PowerInterface
{
    use PowerTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Target character of this power effect
     *
     * @var Character
     *
     * @ORM\ManyToOne(targetEntity=Character::class, inversedBy="itemPowerEffects")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    protected $character;

    /**
     * PowerTrait that triggered this power effect
     *
     * @var ItemPower|null Target of the power or null if the corresponding power
     *
     * @ORM\ManyToOne(targetEntity=ItemPower::class)
     * @ORM\JoinColumn(name="power_id", referencedColumnName="id", nullable=false)
     * @ORM\Cache()
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
     * @param ItemPower $power
     *
     * @return $this
     */
    public function setPower(ItemPower $power)
    {
        $this->power = $power;

        return $this;
    }

    /**
     * @return ItemPower|null
     */
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
     * @return ItemPowerEffect
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

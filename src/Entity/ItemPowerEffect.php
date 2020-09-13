<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Traits\Power;


/**
 * ItemPowerEffect
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Cache()
 */
class ItemPowerEffect
{
    use Power;

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
     * @ORM\ManyToOne(targetEntity="Character", inversedBy="itemPowerEffects")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    protected $character;

    /**
     * Power that triggered this power effect
     *
     * @var Character|null Target of the power or null if the corresponding power
     *
     * @ORM\ManyToOne(targetEntity="ItemPower")
     * @ORM\JoinColumn(name="power_id", referencedColumnName="id", nullable=false)
     * @ORM\Cache()
     */
    protected $power;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $active = false;

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
        return $this->getPower()->getName();
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
     * @return ItemPower
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * @param Character $character
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

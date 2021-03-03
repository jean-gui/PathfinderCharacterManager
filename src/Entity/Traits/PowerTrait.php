<?php

namespace App\Entity\Traits;

use App\Entity\PowerInterface;
use Doctrine\ORM\Mapping as ORM;

trait PowerTrait
{
    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $passive = false;

    /**
     * @var array
     *
     * @ORM\Column(type="json", nullable=true)
     */
    protected $effects;

    /**
     * @var array
     *
     * @ORM\Column(type="json", nullable=true)
     */
    protected $conditions;

    /**
     * @var array
     *
     * @ORM\Column(type="json", nullable=true)
     */
    protected $externalConditions;

    /**
     * @var string[]
     *
     * @ORM\Column(type="json", nullable=true)
     */
    protected $prerequisities;

    /**
     * Set passive
     *
     * @param boolean $passive
     *
     * @return $this
     */
    public function setPassive(bool $passive): PowerInterface
    {
        $this->passive = $passive;

        return $this;
    }

    /**
     * Get passive
     *
     * @return boolean
     */
    public function isPassive(): bool
    {
        return $this->passive;
    }

    /**
     * Set effects
     *
     * @param array $effect
     *
     * @return $this
     */
    public function setEffects(array $effect): PowerInterface
    {
        $this->effects = $effect;

        return $this;
    }

    /**
     * Get effects
     *
     * @return array
     */
    public function getEffects(): ?array
    {
        return $this->effects;
    }

    /**
     * @return bool
     */
    public function hasEffects(): bool
    {
        return $this->getEffects() && count($this->getEffects()) > 0;
    }

    /**
     * Set conditions
     *
     * @param array $conditions
     *
     * @return $this
     */
    public function setConditions(array $conditions): PowerInterface
    {
        $this->conditions = $conditions;

        return $this;
    }

    /**
     * Get conditions
     *
     * @return array
     */
    public function getConditions(): ?array
    {
        return $this->conditions;
    }

    /**
     * Set external conditions
     *
     * @param array $externalConditions
     *
     * @return $this
     */
    public function setExternalConditions(array $externalConditions): PowerInterface
    {
        $this->externalConditions = $externalConditions;

        return $this;
    }

    /**
     * Get external conditions
     *
     * @return array
     */
    public function getExternalConditions(): ?array
    {
        return $this->externalConditions;
    }

    /**
     * @return bool
     */
    public function hasExternalConditions(): bool
    {
        return count($this->externalConditions) > 0;
    }

    /**
     * Set prerequisities
     *
     * @param array $prerequisities
     *
     * @return $this
     */
    public function setPrerequisities(array $prerequisities): PowerInterface
    {
        $this->prerequisities = $prerequisities;

        return $this;
    }

    /**
     * Get prerequisities
     *
     * @return array
     */
    public function getPrerequisities(): ?array
    {
        return $this->prerequisities;
    }
}

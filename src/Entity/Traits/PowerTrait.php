<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait PowerTrait {
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
    public function setPassive(bool $passive)
    {
        $this->passive = $passive;

        return $this;
    }

    /**
     * Get passive
     *
     * @return boolean
     */
    public function isPassive()
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
    public function setEffects(array $effect)
    {
        $this->effects = $effect;

        return $this;
    }

    /**
     * Get effects
     *
     * @return array
     */
    public function getEffects()
    {
        return $this->effects;
    }

    /**
     * @return bool
     */
    public function hasEffects()
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
    public function setConditions(array $conditions)
    {
        $this->conditions = $conditions;

        return $this;
    }

    /**
     * Get conditions
     *
     * @return array
     */
    public function getConditions()
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
    public function setExternalConditions(array $externalConditions)
    {
        $this->externalConditions = $externalConditions;

        return $this;
    }

    /**
     * Get external conditions
     *
     * @return array
     */
    public function getExternalConditions()
    {
        return $this->externalConditions;
    }

    /**
     * @return bool
     */
    public function hasExternalConditions()
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
    public function setPrerequisities(array $prerequisities)
    {
        $this->prerequisities = $prerequisities;

        return $this;
    }

    /**
     * Get prerequisities
     *
     * @return array
     */
    public function getPrerequisities()
    {
        return $this->prerequisities;
    }
} 
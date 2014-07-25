<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 25/07/14
 * Time: 20:27
 */

namespace Troulite\PathfinderBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait Power
 *
 * @package Troulite\PathfinderBundle\Entity\Traits
 */
trait Power {

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $passive = false;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $effects;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $conditions;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $externalConditions;

    /**
     * Set passive
     *
     * @param boolean $passive
     *
     * @return $this
     */
    public function setPassive($passive)
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
    public function setEffects($effect)
    {
        $this->effects = $effect;

        return $this;
    }

    /**
     * Get effects
     *
     * @return string[]
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
        return count($this->getEffects()) > 0;
    }

    /**
     * Set conditions
     *
     * @param array $conditions
     *
     * @return $this
     */
    public function setConditions($conditions)
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
    public function setExternalConditions($externalConditions)
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
} 
<?php

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Feat
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Troulite\PathfinderBundle\Repository\FeatRepository")
 */
class Feat
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $passive = false;

    /**
     * @var string[]
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $prerequisities;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $effect;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Feat
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * Set description
     *
     * @param string $description
     *
     * @return Feat
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set passive
     *
     * @param boolean $passive
     *
     * @return Feat
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
     * Set effect
     *
     * @param array $effect
     *
     * @return Feat
     */
    public function setEffect($effect)
    {
        $this->effect = $effect;

        return $this;
    }

    /**
     * Get effect
     *
     * @return string[]
     */
    public function getEffect()
    {
        return $this->effect;
    }

    /**
     * @return bool
     */
    public function hasEffects()
    {
        return count($this->getEffect()) > 0;
    }

    /**
     * Set prerequisities
     *
     * @param array $prerequisities
     *
     * @return Feat
     */
    public function setPrerequisities($prerequisities)
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

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set conditions
     *
     * @param array $conditions
     *
     * @return Feat
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
     * @return Feat
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

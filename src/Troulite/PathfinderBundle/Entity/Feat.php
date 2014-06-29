<?php

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Feat
 *
 * @ORM\Table()
 * @ORM\Entity
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
    private $worksIf;


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
    public function getPassive()
    {
        return $this->passive;
    }

    /**
     * Set effect
     *
     * @param array $effect
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
     * @return array
     */
    public function getEffect()
    {
        return $this->effect;
    }

    /**
     * Set prerequisities
     *
     * @param array $prerequisities
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

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set worksIf
     *
     * @param array $worksIf
     * @return Feat
     */
    public function setWorksIf($worksIf)
    {
        $this->worksIf = $worksIf;

        return $this;
    }

    /**
     * Get worksIf
     *
     * @return array
     */
    public function getWorksIf()
    {
        return $this->worksIf;
    }
}

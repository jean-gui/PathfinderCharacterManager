<?php

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Race
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Race
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $traits;

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
     * @return Race
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
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set traits
     *
     * @param array $traits
     *
     * @return Race
     */
    public function setTraits($traits)
    {
        $this->traits = $traits;

        return $this;
    }

    /**
     * Get traits
     *
     * @return array
     */
    public function getTraits()
    {
        return $this->traits;
    }
}

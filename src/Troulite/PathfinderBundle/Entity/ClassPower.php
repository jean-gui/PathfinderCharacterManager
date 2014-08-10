<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 25/07/14
 * Time: 22:47
 */

namespace Troulite\PathfinderBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Troulite\PathfinderBundle\Entity\Traits\Power;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class ClassPower
 *
 * @ORM\Entity()
 *
 * @package Troulite\PathfinderBundle\Entity
 */
class ClassPower
{
    use Power;

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
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Gedmo\Translatable()
     */
    private $name;

    /**
     * @var ClassDefinition
     *
     * @ORM\ManyToOne(targetEntity="ClassDefinition", inversedBy="powers")
     * @ORM\JoinColumn(name="class_id", referencedColumnName="id", nullable=false)
     */
    private $class;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $level;

    /**
     * @var bool Whether the power acts as a spell and is castable
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $castable = false;

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
     * @param $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $level
     *
     * @return $this
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param ClassDefinition $class
     *
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return ClassDefinition
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param $castable
     *
     * @return $this
     */
    public function setCastable($castable = false)
    {
        $this->castable = $castable;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCastable()
    {
        return $this->castable;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
} 
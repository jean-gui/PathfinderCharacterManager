<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 29/06/14
 * Time: 18:54
 */

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Troulite\PathfinderBundle\Entity\Traits\Describable;
use Troulite\PathfinderBundle\Entity\Traits\Power;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * PowerEffect
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class PowerEffect
{
    use Power;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Character who cast the power responsible for this effect
     *
     * @var Character|null The caster or null if it comes from an unknown source
     *
     * @ORM\ManyToOne(targetEntity="Character")
     * @ORM\JoinColumn(name="caster_id", referencedColumnName="id", nullable=true)
     */
    protected $caster;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=false)
     */
    protected $casterLevel;

    /**
     * Target character of this power effect
     *
     * @var Character
     *
     * @ORM\ManyToOne(targetEntity="Character", inversedBy="powerEffects")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    protected $character;

    /**
     * Power that triggered this power effect
     *
     * @var Character|null Target of the power or null if the corresponding power
     *
     * @ORM\ManyToOne(targetEntity="ClassPower")
     * @ORM\JoinColumn(name="power_id", referencedColumnName="id", nullable=false)
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
     * @param mixed $caster
     *
     * @return $this
     */
    public function setCaster($caster)
    {
        $this->caster = $caster;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCaster()
    {
        return $this->caster;
    }

    /**
     * @param int $casterLevel
     *
     * @return $this
     */
    public function setCasterLevel($casterLevel)
    {
        $this->casterLevel = $casterLevel;

        return $this;
    }

    /**
     * @return int
     */
    public function getCasterLevel()
    {
        return $this->casterLevel;
    }

    /**
     * @param ClassPower $power
     *
     * @return $this
     */
    public function setPower(ClassPower $power)
    {
        $this->power = $power;

        return $this;
    }

    /**
     * @return ClassPower
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
     * @return CharacterFeat
     */
    public function setActive($active)
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

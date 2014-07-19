<?php

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Weapon
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Weapon extends Item
{
    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255, nullable=false)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var bool
     *
     * @ORM\Column(name="dual_wield", type="boolean", nullable=false)
     */
    private $dualWield;

    /**
     * @var string
     *
     * @ORM\Column(name="range", type="string", length=255, nullable=true)
     */
    private $range;

    /**
     * @var string
     *
     * @ORM\Column(name="damages", type="string", length=255)
     */
    private $damages;

    /**
     * @var integer
     *
     * @ORM\Column(name="critical", type="smallint")
     */
    private $critical;

    /**
     * Set category
     *
     * @param string $category
     * @return Weapon
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Weapon
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set range
     *
     * @param string $range
     * @return Weapon
     */
    public function setRange($range)
    {
        $this->range = $range;

        return $this;
    }

    /**
     * Get range
     *
     * @return string
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * @param $damages
     *
     * @return $this
     */
    public function setDamages($damages)
    {
        $this->damages = $damages;

        return $this;
    }

    /**
     * Get damages
     *
     * @return array
     */
    public function getDamages()
    {
        return $this->damages;
    }

    /**
     * Set critical
     *
     * @param integer $critical
     * @return Weapon
     */
    public function setCritical($critical)
    {
        $this->critical = $critical;

        return $this;
    }

    /**
     * Get critical
     *
     * @return integer
     */
    public function getCritical()
    {
        return $this->critical;
    }

    /**
     * Set dualWield
     *
     * @param boolean $dualWield
     * @return Weapon
     */
    public function setDualWield($dualWield)
    {
        $this->dualWield = $dualWield;

        return $this;
    }

    /**
     * Get dualWield
     *
     * @return boolean
     */
    public function isDualWield()
    {
        return $this->dualWield;
    }
}

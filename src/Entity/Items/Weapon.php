<?php

namespace App\Entity\Items;

use Doctrine\ORM\Mapping as ORM;

/**
 * Weapon
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Weapon extends Item
{
    const CATEGORIES = [
        'Simple'  => 'simple',
        'Martial' => 'martial',
        'Exotic'  => 'exotic',
    ];

    const TYPES = [
        'Great Sword' => 'greatsword',
        'Longbow'     => 'longbow',
        'Long Sword'  => 'longsword',
        'Polearm'     => 'polearm',
        'Short Sword' => 'shortsword',
        'Whip'        => 'whip',
        'Kukri'       => 'kukri'
    ];

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255, nullable=false)
     */
    protected $category;

    /**
     * @var boolean
     *
     * @ORM\Column(name="light", type="boolean", nullable=false, options={"default": false})
     */
    protected $light = false;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    protected $type;

    /**
     * @var bool
     *
     * @ORM\Column(name="two_handed", type="boolean", nullable=false)
     */
    protected $twoHanded;

    /**
     * @var string
     *
     * @ORM\Column(name="range", type="string", length=255, nullable=true)
     */
    protected $range;

    /**
     * @var string
     *
     * @ORM\Column(name="damages", type="string", length=255)
     */
    protected $damages;

    /**
     * @var integer
     *
     * @ORM\Column(name="critical_range", type="smallint", nullable=true)
     */
    protected $criticalRange;

    /**
     * @var integer
     *
     * @ORM\Column(name="critical", type="smallint")
     */
    protected $critical;

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Weapon
     */
    public function setCategory(string $category)
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
     * @return boolean
     */
    public function isLight()
    {
        return $this->light;
    }

    /**
     * @param boolean $light
     *
     * @return $this
     */
    public function setLight(bool $light)
    {
        $this->light = $light;

        return $this;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Weapon
     */
    public function setType(string $type)
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
     *
     * @return Weapon
     */
    public function setRange(string $range)
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
     * @return string|null
     */
    public function getDamages()
    {
        return $this->damages;
    }

    /**
     * Set critical
     *
     * @param integer $critical
     *
     * @return Weapon
     */
    public function setCritical(int $critical)
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
     * Set critical range
     *
     * @param integer $criticalRange
     *
     * @return Weapon
     */
    public function setCriticalRange(int $criticalRange)
    {
        $this->criticalRange = $criticalRange;

        return $this;
    }

    /**
     * Get critical range
     *
     * @return integer
     */
    public function getCriticalRange()
    {
        return $this->criticalRange;
    }

    /**
     * Set twoHanded
     *
     * @param boolean $twoHanded
     *
     * @return Weapon
     */
    public function setTwoHanded(bool $twoHanded)
    {
        $this->twoHanded = $twoHanded;

        return $this;
    }

    /**
     * Get twoHanded
     *
     * @return boolean
     */
    public function isTwoHanded()
    {
        return $this->twoHanded;
    }
}

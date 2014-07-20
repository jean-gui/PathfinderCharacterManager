<?php

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Shield
 *
 * @ORM\Table()
 * @ORM\Entity
 *
 * @todo Really implement that class
 */
class Shield extends Item
{
    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255, nullable=false)
     */
    private $category;

    /**
     * @var int
     *
     * @ORM\Column(name="maxDexterityBonus", type="integer", nullable=false)
     */
    private $maximumDexterityBonus = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="armorCheckPenalty", type="integer", nullable=false)
     */
    private $armorCheckPenalty = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="arcaneSpellFailure", type="integer", nullable=false)
     */
    private $arcaneSpellFailure = 0;

    /**
     * Set category
     *
     * @param string $category
     * @return Armor
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
     * @param int $arcaneSpellFailure
     *
     * @return $this
     */
    public function setArcaneSpellFailure($arcaneSpellFailure)
    {
        $this->arcaneSpellFailure = $arcaneSpellFailure;

        return $this;
    }

    /**
     * @return int
     */
    public function getArcaneSpellFailure()
    {
        return $this->arcaneSpellFailure;
    }

    /**
     * @param int $armorCheckPenalty
     *
     * @return $this
     */
    public function setArmorCheckPenalty($armorCheckPenalty)
    {
        $this->armorCheckPenalty = $armorCheckPenalty;

        return $this;
    }

    /**
     * @return int
     */
    public function getArmorCheckPenalty()
    {
        return $this->armorCheckPenalty;
    }

    /**
     * @param int $maximumDexterityBonus
     *
     * @return $this
     */
    public function setMaximumDexterityBonus($maximumDexterityBonus)
    {
        $this->maximumDexterityBonus = $maximumDexterityBonus;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaximumDexterityBonus()
    {
        return $this->maximumDexterityBonus;
    }
}

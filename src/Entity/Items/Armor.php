<?php

namespace App\Entity\Items;

use Doctrine\ORM\Mapping as ORM;

/**
 * Armor
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Armor extends Item
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $ac;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255, nullable=false)
     */
    protected $category;

    /**
     * @var int
     *
     * @ORM\Column(name="maxDexterityBonus", type="integer", nullable=false)
     */
    protected $maximumDexterityBonus = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="armorCheckPenalty", type="integer", nullable=false)
     */
    protected $armorCheckPenalty = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="arcaneSpellFailure", type="integer", nullable=false)
     */
    protected $arcaneSpellFailure = 0;

    /**
     * @param int $ac
     *
     * @return $this
     */
    public function setAc(int $ac)
    {
        $this->ac = $ac;

        return $this;
    }

    /**
     * @return int
     */
    public function getAc()
    {
        return $this->ac;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Armor
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
     * @param int $arcaneSpellFailure
     *
     * @return $this
     */
    public function setArcaneSpellFailure(int $arcaneSpellFailure)
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
    public function setArmorCheckPenalty(int $armorCheckPenalty)
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
    public function setMaximumDexterityBonus(int $maximumDexterityBonus)
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

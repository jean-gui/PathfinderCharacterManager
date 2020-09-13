<?php

namespace App\Entity;

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
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $ac;

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

<?php

namespace App\Entity\Items;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class EquipmentPower extends ItemPower
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    protected $cost;

    /**
     * @param int $cost
     *
     * @return $this
     */
    public function setCost(int $cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * @return int
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        if ($this->cost) {
            return parent::__toString() . ' (+' . $this->cost . ')';
        } else {
            return parent::__toString();
        }
    }
}

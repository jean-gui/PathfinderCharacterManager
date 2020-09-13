<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class EquipmentPower
 *
 * @ORM\Entity()
 *
 * @package App\Entity
 */
class EquipmentPower extends ItemPower
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $cost;

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
} 
<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 25/07/14
 * Time: 21:55
 */

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class EquipmentPower
 *
 * @ORM\Entity()
 *
 * @package Troulite\PathfinderBundle\Entity
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
    public function setCost($cost)
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
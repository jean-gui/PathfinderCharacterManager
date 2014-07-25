<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 25/07/14
 * Time: 21:53
 */

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Troulite\PathfinderBundle\Entity\Traits\Power;

/**
 * Class ItemPower
 *
 * @ORM\Entity()
 * @ORM\InheritanceType(value="SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type")
 * @ORM\DiscriminatorMap(value={"item": "ItemPower", "equipment": "EquipmentPower"})
 *
 * @package Troulite\PathfinderBundle\Entity
 */
class ItemPower {
    use Power;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
} 
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Power;


/**
 * Class ItemPower
 *
 * @ORM\Entity()
 * @ORM\InheritanceType(value="SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type")
 * @ORM\DiscriminatorMap(value={"item": "ItemPower", "equipment": "EquipmentPower"})
 * @ORM\Cache()
 *
 * @package App\Entity
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
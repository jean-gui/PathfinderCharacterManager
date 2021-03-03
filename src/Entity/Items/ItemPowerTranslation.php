<?php

namespace App\Entity\Items;

use App\Entity\Translation;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType(value="SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type")
 * @ORM\DiscriminatorMap({ "item" = ItemPowerTranslation::class, "equipment" = EquipmentPowerTranslation::class })
 */
class ItemPowerTranslation extends Translation
{
}

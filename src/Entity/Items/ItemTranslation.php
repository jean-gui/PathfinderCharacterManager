<?php

namespace App\Entity\Items;

use App\Entity\Translation;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *     "weapon" = "WeaponTranslation", "armor" = "ArmorTranslation", "shield" = "ShieldTranslation",
 *     "shoulders" = "ShouldersTranslation", "ring" = "RingTranslation", "neck" = "NeckTranslation",
 *     "belt" = "BeltTranslation", "wrists" = "WristsTranslation", "feet" = "FeetTranslation",
 *     "hands" = "HandsTranslation", "eyes" = "EyesTranslation", "head" = "HeadTranslation",
 *     "headband" = "HeadbandTranslation", "body" = "BodyTranslation", "chest" = "ChestTranslation",
 *     "item" = "ItemTranslation"
 * })
 */
class ItemTranslation extends Translation
{
}

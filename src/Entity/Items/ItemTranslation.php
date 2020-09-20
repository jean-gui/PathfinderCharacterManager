<?php

namespace App\Entity\Items;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;

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
class ItemTranslation implements TranslationInterface
{
    use TranslationTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $shortDescription;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $longDescription;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $longDescription
     *
     * @return $this
     */
    public function setLongDescription($longDescription)
    {
        $this->longDescription = $longDescription;

        return $this;
    }

    /**
     * @return string
     */
    public function getLongDescription()
    {
        return $this->longDescription;
    }

    /**
     * @param string $shortDescription
     *
     * @return $this
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }
}
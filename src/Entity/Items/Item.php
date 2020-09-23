<?php

namespace App\Entity\Items;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Item
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *     "weapon" = "Weapon", "armor" = "Armor", "shield" = "Shield", "shoulders" = "Shoulders", "ring" = "Ring",
 *     "neck" = "Neck", "belt" = "Belt", "wrists" = "Wrists", "feet" = "Feet", "hands" = "Hands", "eyes" = "Eyes",
 *     "head" = "Head", "headband" = "Headband", "body" = "Body", "chest" = "Chest", "item" = "Item"
 * })
 * @ORM\Cache()
 */
class Item implements TranslatableInterface
{
    use TranslatableTrait;

    /**
     * @Assert\Valid
     */
    protected $translations;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="cost", type="integer")
     */
    protected $cost;

    /**
     * @var double
     *
     * @ORM\Column(name="weight", type="decimal", precision=5, scale=2, nullable=false)
     */
    protected $weight;

    /**
     * @var Collection|ItemPower[]
     *
     * @ORM\ManyToMany(targetEntity=ItemPower::class, cascade={"all"})
     * @ORM\JoinTable(
     *     joinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="power_id", referencedColumnName="id")}
     * )
     * @ORM\Cache()
     */
    protected $powers;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cost
     *
     * @param integer $cost
     *
     * @return $this
     */
    public function setCost(int $cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return integer
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set weight
     *
     * @param double $weight
     *
     * @return $this
     */
    public function setWeight(float $weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return double
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Add power
     *
     * @param ItemPower $power
     *
     * @return $this
     */
    public function addPower(ItemPower $power)
    {
        $this->powers[] = $power;

        return $this;
    }

    /**
     * Remove power
     *
     * @param ItemPower $power
     */
    public function removePower(ItemPower $power)
    {
        $this->powers->removeElement($power);
    }

    /**
     * Get powers
     *
     * @return Collection|ItemPower[]
     */
    public function getPowers()
    {
        return $this->powers;
    }

    public function __get($name)
    {
        $method    = 'get' . ucfirst($name);
        $arguments = [];

        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }

    public function __isset($name)
    {
        return in_array($name, ['name', 'shortDescription', 'longDescription']);
    }

    public function __toString(): string
    {
        return $this->__get('name');
    }
}

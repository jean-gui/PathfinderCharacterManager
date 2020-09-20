<?php

namespace App\Entity\Characters;

use App\Entity\Items\Item;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * InventoryItem
 *
 * @ORM\Table(name="inventory_items")
 * @ORM\Entity()
 */
class InventoryItem
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Character
     *
     * @ORM\ManyToOne(targetEntity=Character::class, inversedBy="inventoryItems")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    protected $character;

    /**
     * @var Item
     *
     * @ORM\ManyToOne(targetEntity=Item::class)
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     * @ORM\Cache()
     * @Assert\NotBlank()
     */
    protected $item;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", options={"default": 1})
     */
    protected $quantity = 1;

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
     * @return string
     */
    public function __toString()
    {
        return $this->getItem()->__toString();
    }

    /**
     * @return Character
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * @param Character $character
     *
     * @return $this
     */
    public function setCharacter(Character $character)
    {
        $this->character = $character;

        return $this;
    }

    /**
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param Item $item
     *
     * @return $this
     */
    public function setItem(Item $item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return $this
     */
    public function setQuantity(int $quantity)
    {

        if ($quantity == 0) {
            $this->getCharacter()->removeInventoryItem($this);
        } else {
            $this->quantity = $quantity;
        }

        return $this;
    }
}

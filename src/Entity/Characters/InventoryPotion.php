<?php

namespace App\Entity\Characters;

use App\Entity\Items\Potion;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="inventory_potions")
 * @ORM\Entity()
 */
class InventoryPotion
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
     * @ORM\ManyToOne(targetEntity=Character::class, inversedBy="potions")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    protected $character;

    /**
     * @var Potion
     *
     * @ORM\ManyToOne(targetEntity=Potion::class)
     * @ORM\JoinColumn(name="potion_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    protected $potion;

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
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getPotion()->__toString().'';
    }

    /**
     * @return Potion
     */
    public function getPotion(): ?Potion
    {
        return $this->potion;
    }

    /**
     * @param Potion $potion
     *
     * @return $this
     */
    public function setPotion(Potion $potion): self
    {
        $this->potion = $potion;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return $this
     */
    public function setQuantity(int $quantity): self
    {
        if ($quantity == 0) {
            $this->getCharacter()->removePotion($this);
        } else {
            $this->quantity = $quantity;
        }

        return $this;
    }

    /**
     * @return Character
     */
    public function getCharacter(): ?Character
    {
        return $this->character;
    }

    /**
     * @param Character $character
     *
     * @return $this
     */
    public function setCharacter(Character $character): self
    {
        $this->character = $character;

        return $this;
    }
}

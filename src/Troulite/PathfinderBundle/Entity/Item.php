<?php

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Item
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\MappedSuperclass()
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"weapon" = "Weapon"})
 */
class Item
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="cost", type="integer")
     */
    private $cost;

    /**
     * @var double
     *
     * @ORM\Column(name="weight", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $weight;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $effect;

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
     * Set name
     *
     * @param string $name
     * @return Weapon
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Weapon
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set cost
     *
     * @param integer $cost
     * @return Weapon
     */
    public function setCost($cost)
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
     * @return Weapon
     */
    public function setWeight($weight)
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
     * Set special
     *
     * @param array $special
     * @return Weapon
     */
    public function setSpecial($special)
    {
        $this->special = $special;

        return $this;
    }

    /**
     * Get special
     *
     * @return array
     */
    public function getSpecial()
    {
        return $this->special;
    }

    /**
     * Set effect
     *
     * @param array $effect
     * @return Weapon
     */
    public function setEffect($effect)
    {
        $this->effect = $effect;

        return $this;
    }

    /**
     * Get effect
     *
     * @return array
     */
    public function getEffect()
    {
        return $this->effect;
    }

    public function __toString()
    {
        return $this->getName();
    }
}

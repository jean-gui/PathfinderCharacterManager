<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Counter
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @UniqueEntity("slug")
 */
class Counter
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Character
     *
     * @ORM\ManyToOne(targetEntity="Character", inversedBy="counters")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $character;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    private $slug;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $max;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $current = 0;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $resetOnSleep = true;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $persistent = false;

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
     * Set character
     *
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
     * Get character
     *
     * @return Character
     */
    public function getCharacter()
    {
        return $this->character;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return int
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @param int $max
     *
     * @return $this
     */
    public function setMax(int $max)
    {
        $this->max = $max;

        return $this;
    }

    /**
     * @return int
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @param int $current
     *
     * @return $this
     */
    public function setCurrent(int $current)
    {
        if ($current <= $this->max) {
            $this->current = $current;
        } else {
            $this->current = $this->max;
        }

        return $this;
    }

    /**
     * Increase counter by 1
     *
     * @return $this
     */
    public function increase() {
        if ($this->current < $this->max) {
            $this->current++;
        }

        return $this;
    }

    /**
     * @return boolean
     */
    public function isResetOnSleep()
    {
        return $this->resetOnSleep;
    }

    /**
     * @param boolean $resetOnSleep
     *
     * @return $this
     */
    public function setResetOnSleep(bool $resetOnSleep)
    {
        $this->resetOnSleep = $resetOnSleep;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isPersistent()
    {
        return $this->persistent;
    }

    /**
     * @param boolean $persistent
     *
     * @return $this
     */
    public function setPersistent(bool $persistent)
    {
        $this->persistent = $persistent;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    public function computeSlug(SluggerInterface $slugger)
    {
        if (!$this->slug || '-' === $this->slug) {
            $this->slug = (string) $slugger->slug((string) $this)->lower();
        }
    }
}

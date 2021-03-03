<?php

namespace App\Entity\Rules;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class SpellTranslation implements TranslationInterface
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
     * @Assert\NotBlank
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

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $castingTime;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $components;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $range;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $duration;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $targets;

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

    /**
     * @param mixed $castingTime
     *
     * @return $this
     */
    public function setCastingTime($castingTime)
    {
        $this->castingTime = $castingTime;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCastingTime()
    {
        return $this->castingTime;
    }

    /**
     * @param mixed $components
     *
     * @return $this
     */
    public function setComponents($components)
    {
        $this->components = $components;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
     * @param mixed $duration
     *
     * @return $this
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $range
     *
     * @return $this
     */
    public function setRange($range)
    {
        $this->range = $range;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * @param string $targets
     *
     * @return $this
     */
    public function setTargets(string $targets)
    {
        $this->targets = $targets;

        return $this;
    }

    /**
     * @return string
     */
    public function getTargets()
    {
        return $this->targets;
    }
}

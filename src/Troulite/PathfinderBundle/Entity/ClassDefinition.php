<?php

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ClassDefinition
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ClassDefinition
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $hpDice;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $skillPoints;

    /**
     * @var integer[]
     *
     * @ORM\Column(type="json_array")
     */
    private $bab;

    /**
     * @var integer[]
     *
     * @ORM\Column(type="json_array")
     */
    private $reflexes;

    /**
     * @var integer[]
     *
     * @ORM\Column(type="json_array")
     */
    private $fortitude;

    /**
     * @var integer[]
     *
     * @ORM\Column(type="json_array")
     */
    private $will;

    /**
     * @var integer[]
     *
     * @ORM\Column(type="json_array")
     */
    private $spellsPerDay;

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
     * @return ClassDefinition
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

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set hpDice
     *
     * @param integer $hpDice
     * @return ClassDefinition
     */
    public function setHpDice($hpDice)
    {
        $this->hpDice = $hpDice;

        return $this;
    }

    /**
     * Get hpDice
     *
     * @return integer
     */
    public function getHpDice()
    {
        return $this->hpDice;
    }

    /**
     * Set skillPoints
     *
     * @param integer $skillPoints
     * @return ClassDefinition
     */
    public function setSkillPoints($skillPoints)
    {
        $this->skillPoints = $skillPoints;

        return $this;
    }

    /**
     * Get skillPoints
     *
     * @return integer
     */
    public function getSkillPoints()
    {
        return $this->skillPoints;
    }

    /**
     * Set bab
     *
     * @param array $bab
     * @return ClassDefinition
     */
    public function setBab($bab)
    {
        $this->bab = $bab;

        return $this;
    }

    /**
     * Get bab
     *
     * @return array
     */
    public function getBab()
    {
        return $this->bab;
    }

    /**
     * Set reflexes
     *
     * @param array $reflexes
     * @return ClassDefinition
     */
    public function setReflexes($reflexes)
    {
        $this->reflexes = $reflexes;

        return $this;
    }

    /**
     * Get reflexes
     *
     * @return array
     */
    public function getReflexes()
    {
        return $this->reflexes;
    }

    /**
     * Set fortitude
     *
     * @param array $fortitude
     * @return ClassDefinition
     */
    public function setFortitude($fortitude)
    {
        $this->fortitude = $fortitude;

        return $this;
    }

    /**
     * Get fortitude
     *
     * @return array
     */
    public function getFortitude()
    {
        return $this->fortitude;
    }

    /**
     * Set will
     *
     * @param array $will
     * @return ClassDefinition
     */
    public function setWill($will)
    {
        $this->will = $will;

        return $this;
    }

    /**
     * Get will
     *
     * @return array
     */
    public function getWill()
    {
        return $this->will;
    }

    /**
     * Set spellsPerDay
     *
     * @param array $spellsPerDay
     * @return ClassDefinition
     */
    public function setSpellsPerDay($spellsPerDay)
    {
        $this->spellsPerDay = $spellsPerDay;

        return $this;
    }

    /**
     * Get spellsPerDay
     *
     * @return array
     */
    public function getSpellsPerDay()
    {
        return $this->spellsPerDay;
    }
}

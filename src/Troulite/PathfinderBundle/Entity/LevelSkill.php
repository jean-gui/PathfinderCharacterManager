<?php

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * LevelSkill
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class LevelSkill
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
     * @var Level
     *
     * @ORM\ManyToOne(targetEntity="Level", inversedBy="skills")
     * @ORM\JoinColumn(name="level_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $level;

    /**
     * @var Skill
     *
     * @ORM\ManyToOne(targetEntity="Skill")
     * @ORM\JoinColumn(name="skill_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $skill;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $value = 0;

    /**
     * @param Level $level
     * @param Skill $skill
     * @param int $value
     */
    public function __construct(Level $level = null, Skill $skill = null, $value = 0)
    {
        $this->level = $level;
        $this->skill = $skill;
        $this->value = $value;
    }

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
     * Set value
     *
     * @param integer $value
     * @return LevelSkill
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set level
     *
     * @param Level $level
     * @return LevelSkill
     */
    public function setLevel(Level $level = null)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return Level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set skill
     *
     * @param Skill $skill
     * @return LevelSkill
     */
    public function setSkill(Skill $skill = null)
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * Get skill
     *
     * @return Skill
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getSkill()->__toString();
    }
}

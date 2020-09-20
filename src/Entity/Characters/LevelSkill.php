<?php

namespace App\Entity\Characters;

use App\Entity\Rules\Skill;
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
    protected $id;

    /**
     * @var Level
     *
     * @ORM\ManyToOne(targetEntity=Level::class, inversedBy="skills")
     * @ORM\JoinColumn(name="level_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    protected $level;

    /**
     * @var Skill
     *
     * @ORM\ManyToOne(targetEntity=Skill::class)
     * @ORM\JoinColumn(name="skill_id", referencedColumnName="id")
     * @Assert\NotBlank()
     * @ORM\Cache()
     */
    protected $skill;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $value = 0;

    /**
     * @param Level|null $level
     * @param Skill|null $skill
     * @param int        $value
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
     *
     * @return LevelSkill
     */
    public function setValue(int $value)
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
     * @param Level|null $level
     *
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
     * @param Skill|null $skill
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

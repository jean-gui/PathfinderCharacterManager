<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Model\AbilitiesBonuses;

/**
 * Class Abilities
 *
 * @package App\Entity
 *
 * @ORM\Entity()
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
 */
class Abilities
{
    /**
     * Strength identifier
     */
    const STRENGTH     = 'strength';
    /**
     * Dexterity identifier
     */
    const DEXTERITY    = 'dexterity';
    /**
     * Constitution identifier
     */
    const CONSTITUTION = 'constitution';
    /**
     * Intelligence identifier
     */
    const INTELLIGENCE = 'intelligence';
    /**
     * Wisdom identifier
     */
    const WISDOM       = 'wisdom';
    /**
     * Charisma identifier
     */
    const CHARISMA     = 'charisma';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $baseStrength;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $baseDexterity;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $baseConstitution;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $baseIntelligence;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $baseWisdom;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $baseCharisma;

    private $bonuses;

    /**
     * @param $strength
     * @param $dexterity
     * @param $constitution
     * @param $intelligence
     * @param $wisdom
     * @param $charisma
     */
    public function __construct(
        $strength = 10,
        $dexterity = 10,
        $constitution = 10,
        $intelligence = 10,
        $wisdom = 10,
        $charisma = 10)
    {
        $this->baseStrength     = $strength;
        $this->baseDexterity    = $dexterity;
        $this->baseConstitution = $constitution;
        $this->baseIntelligence = $intelligence;
        $this->baseWisdom       = $wisdom;
        $this->baseCharisma     = $charisma;

        $this->bonuses = new AbilitiesBonuses();
    }

    /**
     * @ORM\PostLoad()
     */
    public function postLoad()
    {
        $this->bonuses = new AbilitiesBonuses();
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
     * Get strength
     *
     * @return integer
     */
    public function getBaseStrength()
    {
        return $this->baseStrength;
    }

    public function setBaseStrength(int $baseStrength): self
    {
        $this->baseStrength = $baseStrength;

        return $this;
    }


    public function getBaseDexterity(): int
    {
        return $this->baseDexterity;
    }

    public function setBaseDexterity(int $baseDexterity): self
    {
        $this->baseDexterity = $baseDexterity;

        return $this;
    }

    /**
     * Get constitution
     *
     * @return integer
     */
    public function getBaseConstitution(): int
    {
        return $this->baseConstitution;
    }

    public function setBaseConstitution(int $baseConstitution): self
    {
        $this->baseConstitution = $baseConstitution;

        return $this;
    }

    public function getBaseIntelligence(): int
    {
        return $this->baseIntelligence;
    }

    public function setBaseIntelligence(int $baseIntelligence): self
    {
        $this->baseIntelligence = $baseIntelligence;

        return $this;
    }

    public function getBaseWisdom()
    {
        return $this->baseWisdom;
    }

    public function setBaseWisdom(int $baseWisdom): self
    {
        $this->baseWisdom = $baseWisdom;

        return $this;
    }

    public function getBaseCharisma(): int
    {
        return $this->baseCharisma;
    }

    public function setBaseCharisma(int $baseCharisma): self
    {
        $this->baseCharisma = $baseCharisma;

        return $this;
    }
}

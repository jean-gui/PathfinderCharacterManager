<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 29/06/14
 * Time: 18:54
 */

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Troulite\PathfinderBundle\Model\Character;

/**
 * BaseCharacter
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Party
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="dm_id", referencedColumnName="id")
     */
    private $dungeonMaster;

    /**
     * @var Collection|BaseCharacter[]
     *
     * @ORM\OneToMany(targetEntity="BaseCharacter", mappedBy="party")
     */
    private $characters;

    /**
     * Add characters
     *
     * @param BaseCharacter $character
     *
     * @return Group
     */
    public function addCharacter(BaseCharacter $character)
    {
        $this->characters[] = $character;

        return $this;
    }

    /**
     * Remove characters
     *
     * @param BaseCharacter $character
     */
    public function removeCharacter(BaseCharacter $character)
    {
        $this->characters->removeElement($character);
    }

    /**
     * Get characters
     *
     * @return Collection|BaseCharacter[]
     */
    public function getBaseCharacters()
    {
        return $this->characters;
    }

    /**
     * @return Collection|Character[]
     */
    public function getCharacters()
    {
        $characters = new ArrayCollection();
        foreach ($this->characters as $character) {
            $characters->add(new Character($character));
        }

        return $characters;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->characters = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Party
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
     * Set dungeonMaster
     *
     * @param User $dungeonMaster
     *
     * @return Party
     */
    public function setDungeonMaster(User $dungeonMaster = null)
    {
        $this->dungeonMaster = $dungeonMaster;

        return $this;
    }

    /**
     * Get dungeonMaster
     *
     * @return User
     */
    public function getDungeonMaster()
    {
        return $this->dungeonMaster;
    }
}

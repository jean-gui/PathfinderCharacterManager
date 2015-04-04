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

/**
 * Party
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
     * @var Collection|Character[]
     *
     * @ORM\OneToMany(targetEntity="Character", mappedBy="party")
     */
    private $characters;

    /**
     * @var Logbook
     *
     * @ORM\OneToOne(targetEntity="Logbook", mappedBy="party", cascade={"all"})
     */
    private $logbook;

    /**
     * Add characters
     *
     * @param Character $character
     *
     * @return Group
     */
    public function addCharacter(Character $character)
    {
        $this->characters[] = $character;

        return $this;
    }

    /**
     * Remove characters
     *
     * @param Character $character
     */
    public function removeCharacter(Character $character)
    {
        $this->characters->removeElement($character);
    }

    /**
     * Get characters
     *
     * @return Collection|Character[]
     */
    public function getCharacters()
    {
        return $this->characters;
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

    /**
     * @return string
     */
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

    /**
     * @return Logbook
     */
    public function getLogbook()
    {
        return $this->logbook;
    }

    /**
     * @param Logbook $logbook
     *
     * @return $this
     */
    public function setLogbook(Logbook $logbook)
    {
        $this->logbook = $logbook;
        $logbook->setParty($this);

        return $this;
    }
}

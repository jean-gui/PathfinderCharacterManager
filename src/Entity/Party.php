<?php

namespace App\Entity;

use App\Entity\Characters\Character;
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
    protected $name;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="partiesAsDm")
     * @ORM\JoinColumn(name="dm_id", referencedColumnName="id")
     */
    protected $dungeonMaster;

    /**
     * @var Collection|Character[]
     *
     * @ORM\OneToMany(targetEntity=Character::class, mappedBy="party")
     */
    protected $characters;

    /**
     * @var string
     *
     * @ORM\Column(name="discord_dsn", type="string", nullable=true)
     * @Assert\Url(protocols={"discord"})
     */
    protected $discordDsn;

    /**
     * Add characters
     *
     * @param Character $character
     *
     * @return Party
     */
    public function addCharacter(Character $character): self
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
    public function setName(string $name)
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
     * @param User|null $dungeonMaster
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
     * @return string|null
     */
    public function getDiscordDsn(): ?string
    {
        return $this->discordDsn;
    }

    /**
     * @param string|null $discordDsn
     *
     * @return Party
     */
    public function setDiscordDsn(?string $discordDsn): Party
    {
        $this->discordDsn = $discordDsn;

        return $this;
    }
}

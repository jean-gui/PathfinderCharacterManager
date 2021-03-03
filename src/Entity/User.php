<?php

namespace App\Entity;

use App\Entity\Characters\BaseCharacter;
use App\Entity\Characters\Character;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="json")
     */
    protected $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @var Collection|Character[]
     *
     * @ORM\OneToMany(targetEntity=Character::class, mappedBy="user")
     */
    protected $characters;

    /**
     * @var Collection|Party[]
     *
     * @ORM\OneToMany(targetEntity=Party::class, mappedBy="dungeonMaster")
     */
    protected $partiesAsDm;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    public function __construct()
    {
        $this->partiesAsDm = new ArrayCollection();
        $this->characters  = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function addBaseCharacter(BaseCharacter $characters)
    {
        $this->characters[] = $characters;

        return $this;
    }

    public function removeBaseCharacter(BaseCharacter $characters)
    {
        $this->characters->removeElement($characters);
    }

    public function getBaseCharacters()
    {
        return $this->characters;
    }

    /**
     * @return Collection|Character[]
     */
    public function getCharacters()
    {
        return $this->characters;
    }

    /**
     * Get parties as DM
     *
     * @return Collection|Party[]
     */
    public function getPartiesAsDm()
    {
        return $this->partiesAsDm;
    }

    /**
     * Get parties
     *
     * @return Party[]
     */
    public function getParties()
    {
        $parties = new ArrayCollection();
        foreach ($this->getBaseCharacters() as $character) {
            if ($character->getParty() && !$parties->contains($character->getParty())) {
                $parties->add($character->getParty());
            }
        }

        $mergedParties = array_merge((array)$parties->toArray(), (array)$this->getPartiesAsDm()->toArray());

        return array_unique($mergedParties, SORT_REGULAR);
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}

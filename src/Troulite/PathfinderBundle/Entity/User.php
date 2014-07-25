<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 29/06/14
 * Time: 01:23
 */

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use FOS\UserBundle\Model\GroupInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Collection|Group[]
     * @ORM\ManyToMany(targetEntity="Group", mappedBy="users")
     */
    protected $groups;

    /**
     * @var Collection|Character[]
     *
     * @ORM\OneToMany(targetEntity="Character", mappedBy="user")
     */
    private $characters;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->groups = new ArrayCollection();
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
     * Add groups
     *
     * @param GroupInterface $groups
     *
     * @return User
     */
    public function addGroup(GroupInterface $groups)
    {
        $this->groups[] = $groups;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param GroupInterface $groups
     *
     * @return $this|void
     */
    public function removeGroup(GroupInterface $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return Collection
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Add characters
     *
     * @param BaseCharacter $characters
     *
     * @return User
     */
    public function addBaseCharacter(BaseCharacter $characters)
    {
        $this->characters[] = $characters;

        return $this;
    }

    /**
     * Remove characters
     *
     * @param BaseCharacter $characters
     */
    public function removeBaseCharacter(BaseCharacter $characters)
    {
        $this->characters->removeElement($characters);
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
     * Get parties
     *
     * @return Collection|Party[]
     */
    public function getParties()
    {
        $parties = new ArrayCollection();
        foreach ($this->getBaseCharacters() as $character) {
            if ($character->getParty() && !$parties->contains($character->getParty())) {
                $parties->add($character->getParty());
            }
        }

        return $parties;
    }
}

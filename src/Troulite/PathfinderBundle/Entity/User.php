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
     * @param Character $characters
     * @return User
     */
    public function addCharacter(Character $characters)
    {
        $this->characters[] = $characters;

        return $this;
    }

    /**
     * Remove characters
     *
     * @param Character $characters
     */
    public function removeCharacter(Character $characters)
    {
        $this->characters->removeElement($characters);
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
     * Get parties
     *
     * @return Collection|Party[]
     */
    public function getParties()
    {
        $parties = new ArrayCollection();
        foreach ($this->getCharacters() as $character) {
            ;
            if ($character->getParty()) {
                $parties->add($character->getParty());
            }
        }

        return $parties;
    }
}

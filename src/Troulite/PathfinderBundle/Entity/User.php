<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 29/06/14
 * Time: 01:23
 */
/*
 * Copyright 2015 Jean-Guilhem Rouel
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\GroupInterface;
use FOS\UserBundle\Model\User as BaseUser;

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
     * @var Collection|Party[]
     *
     * @ORM\OneToMany(targetEntity="Party", mappedBy="dungeonMaster")
     */
    private $partiesAsDm;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->groups = new ArrayCollection();
        $this->partiesAsDm = new ArrayCollection();
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
        $parties = array_merge((array) $parties->toArray(), (array) $this->getPartiesAsDm()->toArray());

        return array_unique($parties, SORT_REGULAR);
    }
}

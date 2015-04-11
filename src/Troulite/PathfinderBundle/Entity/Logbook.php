<?php

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

/**
 * @ORM\Entity()
 * @ORM\Table()
 */
class Logbook
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Party
     *
     * @ORM\OneToOne(targetEntity="Party", inversedBy="logbook", cascade={"all"})
     * @ORM\JoinColumn(name="party_id", referencedColumnName="id")
     */
    private $party;

    /**
     * @var LogbookEntry[]|Collection
     *
     * @ORM\OneToMany(targetEntity="LogbookEntry", mappedBy="logbook", cascade={"all"})
     */
    private $entries;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->entries = new ArrayCollection();
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
     * @return Party
     */
    public function getParty()
    {
        return $this->party;
    }

    /**
     * @param Party $party
     *
     * @return $this
     */
    public function setParty(Party $party)
    {
        $this->party = $party;

        return $this;
    }

    /**
     * @return LogbookEntry[]|Collection
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * @param LogbookEntry[]|Collection $entries
     *
     * @return $this
     */
    public function setEntries(Collection $entries)
    {
        $this->entries = $entries;

        return $this;
    }

    /**
     * @param LogbookEntry $entry
     *
     * @return $this
     */
    public function addEntry(LogbookEntry $entry)
    {
        $this->entries[] = $entry;
        $entry->setLogbook($this);

        return $this;
    }

    /**
     * @param LogbookEntry $entry
     *
     * @return $this
     */
    public function removeEntry(LogbookEntry $entry)
    {
        $this->entries->removeElement($entry);
        $entry->setLogbook(null);

        return $this;
    }
}

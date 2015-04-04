<?php

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

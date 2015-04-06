<?php

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 * @ORM\Table()
 */
class LogbookEntry
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
     * @var string
     *
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", nullable=true)
     */
    private $content;

    /**
     * @var Logbook
     *
     * @ORM\ManyToOne(targetEntity="Logbook", inversedBy="entries")
     * @ORM\JoinColumn(name="logbook_id", referencedColumnName="id", nullable=true)
     */
    private $logbook;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="LogbookEntry", inversedBy="children", cascade={"all"})
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="LogbookEntry", mappedBy="parent", cascade={"all"})
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
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
     * @param $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $content
     *
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param LogbookEntry $parent
     *
     * @return $this
     */
    public function setParent(LogbookEntry $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return LogbookEntry
     */
    public function getParent()
    {
        return $this->parent;
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
    public function setLogbook(Logbook $logbook = null)
    {
        $this->logbook = $logbook;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * @return mixed
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * @return mixed
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * @return mixed
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param LogbookEntry $entry
     *
     * @return $this
     */
    public function addChild(LogbookEntry $entry)
    {
        if (!$this->children) {
            $this->children = new ArrayCollection();
        }
        $this->children->add($entry);
        $entry->setParent($this);
        return $this;
    }

    /**
     * @param LogbookEntry $entry
     *
     * @return $this
     */
    public function removeChild(LogbookEntry $entry)
    {
        if (!$this->children) {
            $this->children = new ArrayCollection();
        }
        $this->children->removeElement($entry);

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }
}

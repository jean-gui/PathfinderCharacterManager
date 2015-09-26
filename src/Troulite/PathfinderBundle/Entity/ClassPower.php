<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 25/07/14
 * Time: 22:47
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


use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Troulite\PathfinderBundle\Entity\Traits\Power;

/**
 * Class ClassPower
 *
 * @ORM\Entity()
 * @ORM\Cache()
 *
 * @package Troulite\PathfinderBundle\Entity
 */
class ClassPower
{
    use Power;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ClassDefinition
     *
     * @ORM\ManyToOne(targetEntity="ClassDefinition", inversedBy="powers")
     * @ORM\JoinColumn(name="class_id", referencedColumnName="id", nullable=true)
     * @ORM\Cache()
     */
    private $class;

    /**
     * @var SubClass
     *
     * @ORM\ManyToOne(targetEntity="SubClass", inversedBy="powers")
     * @ORM\JoinColumn(name="subclass_id", referencedColumnName="id", nullable=true)
     * @ORM\Cache()
     */
    private $subClass;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $level;

    /**
     * @var bool Whether the power acts as a spell and is castable
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $castable = false;

    /**
     * @var ClassPower[]|Collection
     *
     * @ORM\ManyToMany(targetEntity="ClassPower", mappedBy="parents", cascade={"all"})
     * @ORM\Cache()
     */
    private $children;

    /**
     * @var ClassPower[]|Collection
     *
     * @ORM\ManyToMany(targetEntity="ClassPower", inversedBy="children", cascade={"all"})
     * @ORM\JoinTable(name="class_power_children",
     *      joinColumns={@ORM\JoinColumn(name="child_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="parent_id", referencedColumnName="id")}
     *      )
     * @ORM\Cache()
     */
    private $parents;

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
     * @param mixed $level
     *
     * @return $this
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param ClassDefinition $class
     *
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return ClassDefinition
     */
    public function getClass()
    {
        return $this->class;
    }


    /**
     * @param SubClass $subClass
     *
     * @return $this
     */
    public function setSubClass($subClass)
    {
        $this->subClass = $subClass;

        return $this;
    }

    /**
     * @return SubClass
     */
    public function getSubClass()
    {
        return $this->subClass;
    }

    /**
     * @param $castable
     *
     * @return $this
     */
    public function setCastable($castable = false)
    {
        $this->castable = $castable;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCastable()
    {
        return $this->castable;
    }

    /**
     * @return Collection|ClassPower[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return ClassPower[]|Collection
     */
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * @param ClassPower $parent
     *
     * @return $this
     */
    public function addParent(ClassPower $parent)
    {
        $this->parents[] = $parent;
        $parent->children[] = $this;

        return $this;
    }

    /**
     * @param ClassPower $parent
     *
     * @return $this
     */
    public function removeParent(ClassPower $parent)
    {
        $this->parents->remove($parent);
        $parent->children->remove($this);

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
} 
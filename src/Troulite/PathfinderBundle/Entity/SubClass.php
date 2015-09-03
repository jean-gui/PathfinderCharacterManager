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
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Troulite\PathfinderBundle\Entity\Traits\Describable;


/**
 * SubClass
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class SubClass
{
    use Describable;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Translatable()
     */
    private $name;

    /**
     * @var ClassDefinition
     *
     * @ORM\ManyToOne(targetEntity="ClassDefinition", inversedBy="subClasses")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=false)
     */
    private $parent;

    /**
     * @var Collection|ClassPower[]
     *
     * @ORM\OneToMany(targetEntity="ClassPower", mappedBy="subClass", cascade={"all"})
     */
    private $powers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->powers = new ArrayCollection();
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
     * @return SubClass
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
     * @return ClassDefinition
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param ClassDefinition $parent
     *
     * @return $this
     */
    public function setParent(ClassDefinition $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Add powers
     *
     * @param ClassPower $power
     *
     * @return SubClass
     */
    public function addPower(ClassPower $power)
    {
        $this->powers[] = $power;
        $power->setSubClass($this);

        return $this;
    }

    /**
     * Remove powers
     *
     * @param ClassPower $powers
     */
    public function removePower(ClassPower $powers)
    {
        $this->powers->removeElement($powers);
    }

    /**
     * Get powers
     *
     * @param int $level
     *
     * @return Collection|ClassPower[]
     */
    public function getPowers($level = null)
    {
        if ($level) {
            return $this->powers->filter(function (ClassPower $power) use ($level) {
                return $power->getLevel() === $level;
            });
        }

        return $this->powers;
    }
}

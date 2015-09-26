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

/**
 * Skill
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Cache()
 */
class Skill
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Gedmo\Translatable()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="shortname", type="string", length=255)
     */
    private $shortname;

    /**
     * @var boolean
     *
     * @ORM\Column(name="untrained", type="boolean")
     */
    private $untrained = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="armorCheckPenalty", type="boolean")
     */
    private $armorCheckPenalty = false;

    /**
     * @var string
     *
     * @ORM\Column(name="keyAbility", type="string", length=255)
     */
    private $keyAbility;

    /**
     * @var Collection|ClassDefinition[]
     *
     * @ORM\ManyToMany(targetEntity="ClassDefinition", mappedBy="classSkills")
     * @ORM\Cache()
     */
    private $classes;

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
     * @return Skill
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
     * Set shortname
     *
     * @param string $shortname
     *
     * @return Skill
     */
    public function setShortname($shortname)
    {
        $this->shortname = $shortname;

        return $this;
    }

    /**
     * @return string
     */
    public function getShortname()
    {
        return $this->shortname;
    }

    /**
     * Set untrained
     *
     * @param boolean $untrained
     * @return Skill
     */
    public function setUntrained($untrained)
    {
        $this->untrained = $untrained;

        return $this;
    }

    /**
     * Get untrained
     *
     * @return boolean
     */
    public function getUntrained()
    {
        return $this->untrained;
    }

    /**
     * Set armorCheckPenalty
     *
     * @param boolean $armorCheckPenalty
     * @return Skill
     */
    public function setArmorCheckPenalty($armorCheckPenalty)
    {
        $this->armorCheckPenalty = $armorCheckPenalty;

        return $this;
    }

    /**
     * Get armorCheckPenalty
     *
     * @return boolean
     */
    public function getArmorCheckPenalty()
    {
        return $this->armorCheckPenalty;
    }

    /**
     * Set keyAbility
     *
     * @param string $keyAbility
     * @return Skill
     */
    public function setKeyAbility($keyAbility)
    {
        $this->keyAbility = $keyAbility;

        return $this;
    }

    /**
     * Get keyAbility
     *
     * @return string
     */
    public function getKeyAbility()
    {
        return $this->keyAbility;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->classes = new ArrayCollection();
    }

    /**
     * Add classes
     *
     * @param ClassDefinition $classes
     * @return Skill
     */
    public function addClass(ClassDefinition $classes)
    {
        $this->classes[] = $classes;

        return $this;
    }

    /**
     * Remove classes
     *
     * @param ClassDefinition $classes
     */
    public function removeClass(ClassDefinition $classes)
    {
        $this->classes->removeElement($classes);
    }

    /**
     * Get classes
     *
     * @return Collection
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}

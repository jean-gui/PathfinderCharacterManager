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

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Counter
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Counter
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
     * @var Character
     *
     * @ORM\ManyToOne(targetEntity="Character", inversedBy="counters")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $character;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $max;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $current = 0;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $resetOnSleep = true;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $persistent = false;

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
     * Set character
     *
     * @param Character $character
     *
     * @return $this
     */
    public function setCharacter(Character $character)
    {
        $this->character = $character;

        return $this;
    }

    /**
     * Get character
     *
     * @return Character
     */
    public function getCharacter()
    {
        return $this->character;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return int
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @param int $max
     *
     * @return $this
     */
    public function setMax($max)
    {
        $this->max = $max;

        return $this;
    }

    /**
     * @return int
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @param int $current
     *
     * @return $this
     */
    public function setCurrent($current)
    {
        if ($current <= $this->max) {
            $this->current = $current;
        } else {
            $this->current = $this->max;
        }

        return $this;
    }

    /**
     * Increase counter by 1
     *
     * @return $this
     */
    public function increase() {
        if ($this->current < $this->max) {
            $this->current++;
        }

        return $this;
    }

    /**
     * @return boolean
     */
    public function isResetOnSleep()
    {
        return $this->resetOnSleep;
    }

    /**
     * @param boolean $resetOnSleep
     *
     * @return $this
     */
    public function setResetOnSleep($resetOnSleep)
    {
        $this->resetOnSleep = $resetOnSleep;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isPersistent()
    {
        return $this->persistent;
    }

    /**
     * @param boolean $persistent
     *
     * @return $this
     */
    public function setPersistent($persistent)
    {
        $this->persistent = $persistent;

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

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
use Troulite\PathfinderBundle\Entity\Traits\Describable;


/**
 * Class Condition
 *
 * @ORM\Entity()
 * @ORM\Cache()
 *
 * @package Troulite\PathfinderBundle\Entity
 */
class Condition {
    use Describable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $effects;

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
     *
     * @return $this
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
     * Set effects
     *
     * @param array $effect
     *
     * @return $this
     */
    public function setEffects($effect)
    {
        $this->effects = $effect;

        return $this;
    }

    /**
     * Get effects
     *
     * @return string[]
     */
    public function getEffects()
    {
        return $this->effects;
    }

    /**
     * @return bool
     */
    public function hasEffects()
    {
        return count($this->getEffects()) > 0;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
} 
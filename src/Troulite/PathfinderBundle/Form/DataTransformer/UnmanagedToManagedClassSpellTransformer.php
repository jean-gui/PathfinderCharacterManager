<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 14/07/14
 * Time: 21:07
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

namespace Troulite\PathfinderBundle\Form\DataTransformer;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;
use Troulite\PathfinderBundle\Entity\ClassDefinition;
use Troulite\PathfinderBundle\Entity\ClassSpell;


/**
 * Turn a non-managed ClassSpell into a managed one
 *
 * @package Troulite\PathfinderBundle\Form\DataTransformer
 */
class UnmanagedToManagedClassSpellTransformer implements DataTransformerInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var ClassDefinition
     */
    private $classDefinition;

    /**
     * @param EntityManager $em
     * @param ClassDefinition $classDefinition
     */
    public function __construct(EntityManager $em, ClassDefinition $classDefinition)
    {
        $this->em = $em;
        $this->classDefinition = $classDefinition;
    }

    /**
     * Transforms a ClassSpell to a Spell.
     *
     * @param  ClassSpell|null $classSpell
     *
     * @return ClassSpell
     */
    public function transform($classSpell)
    {
        if (!$classSpell) {
            return null;
        }

        return $classSpell;
    }

    /**
     * Transforms a Spell to an existing ClassSpell.
     *
     * @param ClassSpell $spell
     *
     * @return ClassSpell|null
     */
    public function reverseTransform($spell)
    {
        if (!$spell) {
            return null;
        }

        $classSpell = $this->em->getRepository('TroulitePathfinderBundle:ClassSpell')->findOneBy(
            array(
                'spell' => $spell->getSpell(),
                'class' => $this->classDefinition
            )
        );
        return $classSpell;
    }
} 
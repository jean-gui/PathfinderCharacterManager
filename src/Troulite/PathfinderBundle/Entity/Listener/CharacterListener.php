<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 13/03/15
 * Time: 17:02
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

namespace Troulite\PathfinderBundle\Entity\Listener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Troulite\PathfinderBundle\Entity\Character;

/**
 * Class CharacterListener
 *
 * @package Troulite\PathfinderBundle\Entity\Listener
 */
class CharacterListener  {

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        // Cannot pass or retrieve troulite_pathfinder.character_bonuses from here because of circular reference
        $this->container = $container;
    }

    /**
     * @param Character $character
     *
     * @internal param LifecycleEventArgs $event
     */
    public function postLoad(Character $character)
    {
        $character->postLoad();
        $this->container->get('troulite_pathfinder.character_bonuses')->applyAll($character);
    }
}
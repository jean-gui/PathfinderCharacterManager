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

use Symfony\Component\Form\DataTransformerInterface;
use Troulite\PathfinderBundle\Entity\CharacterFeat;
use Troulite\PathfinderBundle\Entity\Feat;
use Troulite\PathfinderBundle\Entity\Level;


/**
 * Turn a Feat into a CharacterFeat and vice-versa
 *
 * @package Troulite\PathfinderBundle\Form\DataTransformer
 */
class FeatToCharacterFeatTransformer implements DataTransformerInterface
{
    /**
     * @var Level
     */
    private $level;

    /**
     * @param Level $level
     */
    public function __construct(Level $level)
    {
        $this->level = $level;
    }

    /**
     * Transforms a CharacterFeat to a Feat.
     *
     * @param  CharacterFeat|null $characterFeat
     *
     * @return Feat[]
     */
    public function transform($characterFeat)
    {
        if (!$characterFeat) {
            return null;
        }

        return $characterFeat->getFeat();
    }

    /**
     * Transforms a Feat to a CharacterFeat.
     *
     * @param Feat $feat
     *
     * @return CharacterFeat|null
     */
    public function reverseTransform($feat)
    {
        if (!$feat) {
            return null;
        }

        $characterFeat = new CharacterFeat();
        $characterFeat->setLevel($this->level);
        $characterFeat->setFeat($feat);

        return $characterFeat;
    }
} 
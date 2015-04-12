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


/**
 * Turn an array to a JSON array
 *
 * @package Troulite\PathfinderBundle\Form\DataTransformer
 */
class ArrayToJsonTransformer implements DataTransformerInterface
{
    /**
     * Transforms an array to a JSON array.
     *
     * @param array $array
     *
     * @return string|null
     */
    public function transform($array)
    {
        if (!$array) {
            return null;
        }

        return json_encode($array, JSON_PRETTY_PRINT);
    }

    /**
     * Transforms a JSON array to an array.
     *
     * @param string $json
     *
     * @return array|null
     */
    public function reverseTransform($json)
    {
        if (!$json) {
            return null;
        }

        return json_decode($json);
    }
} 
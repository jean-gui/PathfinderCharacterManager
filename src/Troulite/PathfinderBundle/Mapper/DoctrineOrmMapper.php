<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 04/04/15
 * Time: 15:47
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

namespace Troulite\PathfinderBundle\Mapper;


use Doctrine\ORM\Mapping\ClassMetadata;
use Midgard\CreatePHP\Mapper\DoctrineOrmMapper as BaseDoctrineOrmMapper;
use Midgard\CreatePHP\Type\TypeInterface;
use Troulite\PathfinderBundle\Entity\LogbookEntry;

/**
 * Class DoctrineOrmMapper
 *
 * @package Troulite\PathfinderBundle\Mapper
 */
class DoctrineOrmMapper extends BaseDoctrineOrmMapper
{
    /**
     * {@inheritDoc}
     *
     * Create the object if a class is defined in the typeMap. This class
     * can not know how to set the parent, so if you ever create collection
     * entries, your extending class should handle the parent - it can still
     * call this method to create the basic object, just omit the parent
     * parameter and then set the parent on the returned value. For an example,
     * see DoctrinePhpcrOdmMapper.
     *
     * Just overwrite if you use a different concept.
     */
    public function prepareObject(TypeInterface $type, $parent = null)
    {
        /** @var LogbookEntry $object */
        $object = parent::prepareObject($type);

        if (null == $parent) {
            throw new \RuntimeException('You need a parent to create new objects');
        }

        /** @var $meta ClassMetadata */
        //$meta = $this->om->getClassMetaData(get_class($object));

        /*
        if (!property_exists($object, $meta->parentMapping)) {
            throw new RuntimeException('parentMapping need to be mapped to '
                . get_class($object));
        }
        */
        if ($parent) {
            $object->setParent($parent);
        }

        //$meta->setFieldValue($object, $meta->parentMapping, $parent);

        return $object;
    }
}
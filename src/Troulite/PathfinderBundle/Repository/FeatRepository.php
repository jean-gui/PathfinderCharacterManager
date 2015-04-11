<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 14/07/14
 * Time: 22:22
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

namespace Troulite\PathfinderBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Troulite\PathfinderBundle\Entity\Feat;
use Troulite\PathfinderBundle\Entity\Character;

/**
 * Class FeatRepository
 *
 * @package Troulite\PathfinderBundle\Repository
 */
class FeatRepository extends EntityRepository
{
    /**
     * Query to find all available feats for a character to pick from
     *
     * @param Character $character
     *
     * @return QueryBuilder
     */
    public function queryAvailableFor(Character $character)
    {
        $characterFeats = $character->getFeats();
        $feats          = array();

        $qb = $this->_em->createQueryBuilder()->select('f')->from('TroulitePathfinderBundle:Feat', 'f');
        foreach ($characterFeats as $characterFeat) {
            if ($characterFeat->getFeat() && $characterFeat->getId()) {
                $feats[] = $characterFeat->getFeat()->getId();
            }
        }
        if(count($feats) > 0) {
            $qb->where($qb->expr()->notIn('f.id', $feats));
        }

        return $qb;
    }

    /**
     * Find all available feats for a character to pick from
     *
     * @param Character $Character
     *
     * @return Feat[]
     */public function findByAvailableFor(Character $Character)
    {
        $query = $this->queryAvailableFor($Character)->getQuery();
        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );
        return $query->getResult();
    }
} 
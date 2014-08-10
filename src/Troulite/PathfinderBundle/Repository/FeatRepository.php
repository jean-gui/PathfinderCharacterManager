<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 14/07/14
 * Time: 22:22
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
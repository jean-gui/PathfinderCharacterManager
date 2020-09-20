<?php

namespace App\Repository;


use App\Entity\Characters\Character;
use App\Entity\Rules\Feat;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class FeatRepository
 *
 * @package App\Repository
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

        $qb = $this->_em->createQueryBuilder()->select('f')->from(Feat::class, 'f');
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
        return $query->getResult();
    }
} 
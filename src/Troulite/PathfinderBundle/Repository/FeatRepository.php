<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 14/07/14
 * Time: 22:22
 */

namespace Troulite\PathfinderBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Troulite\PathfinderBundle\Entity\BaseCharacter;
use Troulite\PathfinderBundle\Entity\Feat;
use Troulite\PathfinderBundle\Model\Character;

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
     * @param BaseCharacter $baseCharacter
     *
     * @return QueryBuilder
     */
    public function queryAvailableFor(BaseCharacter $baseCharacter)
    {
        $character = new Character($baseCharacter);
        $characterFeats = $character->getFeats();
        $feats          = array();

        foreach ($characterFeats as $characterFeat) {
            if ($characterFeat->getFeat()) {
                $feats[] = $characterFeat->getFeat()->getId();
            }
        }

        $qb = $this->_em->createQueryBuilder()->select('f')->from('TroulitePathfinderBundle:Feat', 'f');
        $qb->where($qb->expr()->notIn('f.id', $feats));

        return $qb;
    }

    /**
     * Find all available feats for a character to pick from
     *
     * @param BaseCharacter $baseCharacter
     *
     * @return Feat[]
     */public function findByAvailableFor(BaseCharacter $baseCharacter)
    {
        return $this->queryAvailableFor($baseCharacter)->getQuery()->getResult();
    }
} 
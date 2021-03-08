<?php

namespace App\Repository;

use App\Entity\Rules\Skill;
use Doctrine\ORM\EntityRepository;
use function Symfony\Component\String\u;

/**
 * @method Skill|null find($id, $lockMode = null, $lockVersion = null)
 * @method Skill|null findOneBy(array $criteria, array $orderBy = null)
 * @method Skill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillRepository extends EntityRepository
{
    /**
     * @return Skill[]
     */
    public function findAll(): array
    {
        $qb = $this->createQueryBuilder('s');
        $qb
            ->addSelect('t')
            ->leftJoin('s.translations', 't');

        $skills = $qb->getQuery()->execute();

        // Sort skills by translated name
        usort(
            $skills,
            function (Skill $s1, Skill $s2) {
                return strcmp(u($s1->name)->ascii(), u($s2->name)->ascii());
            }
        );

        return $skills;
    }
}

<?php

namespace App\Repository;

use App\Entity\Rules\ClassDefinition;
use App\Entity\Rules\ClassSpell;
use App\Entity\Rules\SubClass;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * ClassSpellRepository
 *
 * This class was generated by the PhpStorm "Php Annotations" Plugin. Add your own custom
 * repository methods below.
 */
class ClassSpellRepository extends EntityRepository
{
    /**
     * Find a class spell by name and class
     *
     * @param int             $spellId
     * @param ClassDefinition $class
     * @param SubClass[]      $subClasses
     *
     * @return null|ClassSpell
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function findByNameAndClass(int $spellId, ClassDefinition $class, array $subClasses = null)
    {
        if ($subClasses && count($subClasses) > 0) {
            $query = 'SELECT cs FROM '.ClassSpell::class.' cs LEFT JOIN cs.spell s WHERE s.id = :sid AND cs.subClass IN (:cid)';

            $res = $this->_em->createQuery($query)->setParameters(
                [
                    'sid' => $spellId,
                    'cid' => $subClasses,
                ]
            )->getResult();

            if ($res && count($res) > 0) {
                return $res[0];
            }
        }

        // No spell for subclass, let's try for class

        $query = 'SELECT cs FROM '.ClassSpell::class.' cs LEFT JOIN cs.spell s WHERE s.id = :sid AND cs.class = :cid';

        return $this->_em->createQuery($query)->setParameters(
            [
                'sid' => $spellId,
                'cid' => $class->getId(),
            ])->getSingleResult();
    }
}

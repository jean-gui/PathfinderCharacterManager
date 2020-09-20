<?php

namespace App\Controller\Admin\Items;

use App\Entity\Items\Weapon;
use Doctrine\ORM\QueryBuilder;

class WeaponCrudController extends ItemCrudController
{
    public static function getEntityFqcn(): string
    {
        return Weapon::class;
    }

    protected function addClassRestrictions(QueryBuilder $qb): QueryBuilder
    {
        return $qb;
    }
}
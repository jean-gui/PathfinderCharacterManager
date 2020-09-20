<?php

namespace App\Controller\Admin\Items;

use App\Entity\Items\Shield;
use Doctrine\ORM\QueryBuilder;

class ShieldCrudController extends ItemCrudController
{
    public static function getEntityFqcn(): string
    {
        return Shield::class;
    }

    protected function addClassRestrictions(QueryBuilder $qb): QueryBuilder
    {
        return $qb;
    }
}
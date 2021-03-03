<?php

namespace App\Controller\Admin\Items;

use App\Entity\Items\Ring;
use Doctrine\ORM\QueryBuilder;

class RingCrudController extends ItemCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ring::class;
    }

    protected function addClassRestrictions(QueryBuilder $qb): QueryBuilder
    {
        return $qb;
    }
}

<?php

namespace App\Controller\Admin\Items;

use App\Entity\Items\Feet;
use Doctrine\ORM\QueryBuilder;

class FeetCrudController extends ItemCrudController
{
    public static function getEntityFqcn(): string
    {
        return Feet::class;
    }

    protected function addClassRestrictions(QueryBuilder $qb): QueryBuilder
    {
        return $qb;
    }
}
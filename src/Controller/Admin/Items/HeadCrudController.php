<?php

namespace App\Controller\Admin\Items;

use App\Entity\Items\Head;
use Doctrine\ORM\QueryBuilder;

class HeadCrudController extends ItemCrudController
{
    public static function getEntityFqcn(): string
    {
        return Head::class;
    }

    protected function addClassRestrictions(QueryBuilder $qb): QueryBuilder
    {
        return $qb;
    }
}
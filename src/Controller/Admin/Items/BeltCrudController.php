<?php

namespace App\Controller\Admin\Items;

use App\Entity\Items\Belt;
use Doctrine\ORM\QueryBuilder;

class BeltCrudController extends ItemCrudController
{
    public static function getEntityFqcn(): string
    {
        return Belt::class;
    }

    protected function addClassRestrictions(QueryBuilder $qb): QueryBuilder
    {
        return $qb;
    }
}

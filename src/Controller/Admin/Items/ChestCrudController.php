<?php

namespace App\Controller\Admin\Items;

use App\Entity\Items\Chest;
use Doctrine\ORM\QueryBuilder;

class ChestCrudController extends ItemCrudController
{
    public static function getEntityFqcn(): string
    {
        return Chest::class;
    }

    protected function addClassRestrictions(QueryBuilder $qb): QueryBuilder
    {
        return $qb;
    }
}
<?php

namespace App\Controller\Admin\Items;

use App\Entity\Items\Armor;
use Doctrine\ORM\QueryBuilder;

class ArmorCrudController extends ItemCrudController
{
    public static function getEntityFqcn(): string
    {
        return Armor::class;
    }

    protected function addClassRestrictions(QueryBuilder $qb): QueryBuilder
    {
        return $qb;
    }
}
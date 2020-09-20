<?php

namespace App\Controller\Admin\Items;

use App\Entity\Items\Wrists;
use Doctrine\ORM\QueryBuilder;

class WristsCrudController extends ItemCrudController
{
    public static function getEntityFqcn(): string
    {
        return Wrists::class;
    }

    protected function addClassRestrictions(QueryBuilder $qb): QueryBuilder
    {
        return $qb;
    }
}
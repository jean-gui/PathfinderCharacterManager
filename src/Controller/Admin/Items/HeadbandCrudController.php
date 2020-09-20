<?php

namespace App\Controller\Admin\Items;

use App\Entity\Items\Headband;
use Doctrine\ORM\QueryBuilder;

class HeadbandCrudController extends ItemCrudController
{
    public static function getEntityFqcn(): string
    {
        return Headband::class;
    }

    protected function addClassRestrictions(QueryBuilder $qb): QueryBuilder
    {
        return $qb;
    }
}
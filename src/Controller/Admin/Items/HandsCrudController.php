<?php

namespace App\Controller\Admin\Items;

use App\Entity\Items\Hands;
use Doctrine\ORM\QueryBuilder;

class HandsCrudController extends ItemCrudController
{
    public static function getEntityFqcn(): string
    {
        return Hands::class;
    }

    protected function addClassRestrictions(QueryBuilder $qb): QueryBuilder
    {
        return $qb;
    }
}

<?php

namespace App\Controller\Admin\Items;

use App\Entity\Items\Body;
use Doctrine\ORM\QueryBuilder;

class BodyCrudController extends ItemCrudController
{
    public static function getEntityFqcn(): string
    {
        return Body::class;
    }

    protected function addClassRestrictions(QueryBuilder $qb): QueryBuilder
    {
        return $qb;
    }
}
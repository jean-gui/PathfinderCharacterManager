<?php

namespace App\Controller\Admin\Items;

use App\Entity\Items\Neck;
use Doctrine\ORM\QueryBuilder;

class NeckCrudController extends ItemCrudController
{
    public static function getEntityFqcn(): string
    {
        return Neck::class;
    }

    protected function addClassRestrictions(QueryBuilder $qb): QueryBuilder
    {
        return $qb;
    }
}
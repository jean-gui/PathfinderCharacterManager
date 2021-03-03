<?php

namespace App\Controller\Admin\Items;

use App\Entity\Items\Eyes;
use Doctrine\ORM\QueryBuilder;

class EyesCrudController extends ItemCrudController
{
    public static function getEntityFqcn(): string
    {
        return Eyes::class;
    }

    protected function addClassRestrictions(QueryBuilder $qb): QueryBuilder
    {
        return $qb;
    }
}

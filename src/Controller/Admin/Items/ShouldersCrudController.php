<?php

namespace App\Controller\Admin\Items;

use App\Entity\Items\Shoulders;
use Doctrine\ORM\QueryBuilder;

class ShouldersCrudController extends ItemCrudController
{
    public static function getEntityFqcn(): string
    {
        return Shoulders::class;
    }

    protected function addClassRestrictions(QueryBuilder $qb): QueryBuilder
    {
        return $qb;
    }
}

<?php

namespace App\Controller\Admin\Rules;

use App\Controller\Admin\GenericCrudController;
use App\Entity\Items\EquipmentPower;
use App\Entity\Items\ItemPower;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use Doctrine\ORM\QueryBuilder;

class ItemPowerCrudController extends GenericCrudController
{
    public static function getEntityFqcn(): string
    {
        return ItemPower::class;
    }

    protected function addClassRestrictions(QueryBuilder $qb): QueryBuilder
    {
        return $qb->andWhere($qb->expr()->not($qb->expr()->isInstanceOf('entity', EquipmentPower::class)));
    }

    public function createIndexQueryBuilder(
        SearchDto $searchDto,
        EntityDto $entityDto,
        FieldCollection $fields,
        FilterCollection $filters
    ): QueryBuilder {
        $qb = parent::createIndexQueryBuilder(
            $searchDto,
            $entityDto,
            $fields,
            $filters
        );

        return $this->addClassRestrictions($qb);
    }
}

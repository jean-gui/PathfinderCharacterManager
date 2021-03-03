<?php

namespace App\Controller\Admin\Rules;

use App\Entity\Items\EquipmentPower;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class EquipmentPowerCrudController extends ItemPowerCrudController
{
    public static function getEntityFqcn(): string
    {
        return EquipmentPower::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields   = parent::configureFields($pageName);
        $fields[] = IntegerField::new('cost');

        return $fields;
    }

    protected function addClassRestrictions(QueryBuilder $qb): QueryBuilder
    {
        return $qb;
    }
}

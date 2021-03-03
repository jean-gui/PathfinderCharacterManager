<?php

namespace App\Controller\Admin\Items;

use App\Entity\Items\Shield;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class ShieldCrudController extends ItemCrudController
{
    public static function getEntityFqcn(): string
    {
        return Shield::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return array_merge(
            parent::configureFields($pageName),
            [
                IntegerField::new('ac'),
                IntegerField::new('maximumDexterityBonus'),
                IntegerField::new('armorCheckPenalty'),
                IntegerField::new('arcaneSpellFailure')
            ]
        );
    }

    protected function addClassRestrictions(QueryBuilder $qb): QueryBuilder
    {
        return $qb;
    }
}

<?php

namespace App\Controller\Admin\Items;

use App\Entity\Items\Armor;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class ArmorCrudController extends ItemCrudController
{
    public static function getEntityFqcn(): string
    {
        return Armor::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return array_merge(
            parent::configureFields($pageName),
            [
                ChoiceField::new('category')->setChoices(Armor::CATEGORIES),
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

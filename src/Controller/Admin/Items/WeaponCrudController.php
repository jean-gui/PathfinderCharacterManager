<?php

namespace App\Controller\Admin\Items;

use App\Entity\Items\Weapon;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WeaponCrudController extends ItemCrudController
{
    public static function getEntityFqcn(): string
    {
        return Weapon::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return array_merge(
            parent::configureFields($pageName),
            [
                ChoiceField::new('category')->setChoices(Weapon::CATEGORIES),
                BooleanField::new('light'),
                ChoiceField::new('type')->setChoices(Weapon::TYPES),
                BooleanField::new('twoHanded'),
                TextField::new('range'),
                TextField::new('damages'),
                IntegerField::new('criticalRange'),
                IntegerField::new('critical')
            ]
        );
    }

    protected function addClassRestrictions(QueryBuilder $qb): QueryBuilder
    {
        return $qb;
    }
}
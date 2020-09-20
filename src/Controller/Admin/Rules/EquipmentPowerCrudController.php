<?php

namespace App\Controller\Admin\Rules;

use App\Admin\Field\JsonField;
use App\Admin\Field\TranslationField;
use App\Entity\Items\EquipmentPower;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EquipmentPowerCrudController extends ItemPowerCrudController
{
    public static function getEntityFqcn(): string
    {
        return EquipmentPower::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name')->hideOnForm(),
            TextareaField::new('shortDescription')->onlyOnDetail()->renderAsHtml(),
            TextareaField::new('longDescription')->onlyOnDetail()->renderAsHtml(),
            TranslationField::new('translations')->onlyOnForms(),
            BooleanField::new('passive'),
            JsonField::new('effects')->hideOnIndex(),
            JsonField::new('conditions')->hideOnIndex(),
            JsonField::new('externalConditions')->hideOnIndex(),
            JsonField::new('prerequisities')->hideOnIndex(),
            IntegerField::new('cost')
        ];
    }

    protected function addClassRestrictions(QueryBuilder $qb): QueryBuilder
    {
        return $qb;
    }
}

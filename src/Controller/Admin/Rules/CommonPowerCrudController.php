<?php

namespace App\Controller\Admin\Rules;

use App\Admin\Field\JsonField;
use App\Admin\Field\TranslationField;
use App\Controller\Admin\GenericCrudController;
use App\Entity\Rules\CommonPower;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CommonPowerCrudController extends GenericCrudController
{
    public static function getEntityFqcn(): string
    {
        return CommonPower::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name')->hideOnForm(),
            TextareaField::new('shortDescription')->onlyOnDetail()->renderAsHtml(),
            TextareaField::new('longDescription')->onlyOnDetail()->renderAsHtml(),
            TranslationField::new('translations')
                            ->onlyOnForms()
                            ->setFormTypeOption('required', true)
                            ->setFormTypeOption('label', false),
            JsonField::new('effects')->hideOnIndex(),
            JsonField::new('conditions')->hideOnIndex(),
            JsonField::new('externalConditions')->hideOnIndex(),
            JsonField::new('prerequisities')->hideOnIndex(),
        ];
    }
}

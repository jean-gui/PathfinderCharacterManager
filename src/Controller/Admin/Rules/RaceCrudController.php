<?php

namespace App\Controller\Admin\Rules;

use App\Admin\Field\JsonField;
use App\Admin\Field\TranslationField;
use App\Controller\Admin\GenericCrudController;
use App\Entity\Rules\Race;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RaceCrudController extends GenericCrudController
{
    public static function getEntityFqcn(): string
    {
        return Race::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name')->hideOnForm(),
            TranslationField::new('translations')
                            ->onlyOnForms()
                            ->setFormTypeOption('required', true)
                            ->setFormTypeOption('label', false),
            JsonField::new('traits')->hideOnIndex()
        ];
    }
}

<?php

namespace App\Controller\Admin\Rules;

use App\Admin\Field\TranslationField;
use App\Entity\Rules\SubClass;
use App\Form\Classes\ClassPowerType;
use App\Form\Classes\ClassSpellType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SubClassCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SubClass::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $c = parent::configureCrud($crud);

        $searchFields = $c->getAsDto()->getSearchFields();
        $c->setSearchFields(array_merge($searchFields, ['translations.name']));
        $c->addFormTheme('bundles/A2lixTranslationFormBundle/bootstrap_4_layout.html.twig');

        return $c;
    }

    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name')->hideOnForm(),
            TextareaField::new('shortDescription')->onlyOnDetail()->renderAsHtml(),
            TextareaField::new('longDescription')->onlyOnDetail()->renderAsHtml(),
            AssociationField::new('parent'),
            BooleanField::new('extraSpellSlot'),
            TranslationField::new('translations')->onlyOnForms(),
            CollectionField::new('spells')
                           ->hideOnIndex()
                           ->setEntryIsComplex(true)
                           ->setEntryType(ClassSpellType::class)
                           ->setFormTypeOption('by_reference', false),
            CollectionField::new('powers')
                           ->hideOnIndex()
                           ->setEntryIsComplex(true)
                           ->setEntryType(ClassPowerType::class)
                           ->setFormTypeOption('by_reference', false),
        ];
    }
}

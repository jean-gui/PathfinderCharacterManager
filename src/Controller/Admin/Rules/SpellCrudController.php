<?php

namespace App\Controller\Admin\Rules;

use App\Admin\Field\JsonField;
use App\Admin\Field\TranslationField;
use App\Entity\Rules\Spell;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SpellCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Spell::class;
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
            TextField::new('castingTime')->onlyOnDetail(),
            TextField::new('components')->onlyOnDetail(),
            TextField::new('range')->onlyOnDetail(),
            TextField::new('duration')->onlyOnDetail(),
            TextField::new('savingThrow'),
            BooleanField::new('spellResistance'),
            TextField::new('targets')->onlyOnDetail(),
            BooleanField::new('passive'),
            JsonField::new('effects')->hideOnIndex(),
            JsonField::new('conditions')->hideOnIndex(),
            JsonField::new('externalConditions')->hideOnIndex(),
            JsonField::new('prerequisities')->hideOnIndex(),
            TranslationField::new('translations')->onlyOnForms()
        ];
    }
}

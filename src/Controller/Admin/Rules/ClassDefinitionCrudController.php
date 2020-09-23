<?php

namespace App\Controller\Admin\Rules;

use App\Admin\Field\JsonField;
use App\Admin\Field\TranslationField;
use App\Entity\Rules\Abilities;
use App\Entity\Rules\ClassDefinition;
use App\Form\Classes\ClassPowerType;
use App\Form\Classes\ClassSpellType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ClassDefinitionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ClassDefinition::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $c = parent::configureCrud($crud);

        $searchFields = $c->getAsDto()->getSearchFields();
        $c
            ->setSearchFields(array_merge($searchFields, ['translations.name']))
            ->addFormTheme('bundles/A2lixTranslationFormBundle/bootstrap_4_layout.html.twig')
            ->overrideTemplate('crud/new', 'admin/class_definition/new.html.twig')
            ->overrideTemplate('crud/edit', 'admin/class_definition/edit.html.twig')
        ;

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
            TranslationField::new('translations')->onlyOnForms()->setFormTypeOption('required', true),
            IntegerField::new('hpDice')->hideOnIndex(),
            IntegerField::new('skillPoints')->hideOnIndex(),
            AssociationField::new('classSkills')->hideOnIndex(),
            BooleanField::new('prestige'),
            ChoiceField::new('castingAbility')->setChoices(Abilities::ABILITIES)->hideOnIndex(),
            JsonField::new('bab')->hideOnIndex(),
            JsonField::new('reflexes')->hideOnIndex(),
            JsonField::new('fortitude')->hideOnIndex(),
            JsonField::new('will')->hideOnIndex(),
            BooleanField::new('preparationNeeded')->hideOnIndex(),
            BooleanField::new('ableToLearnLowerLevelSpells')->hideOnIndex(),
            BooleanField::new('ableToLearnNewSpells')->hideOnIndex(),
            JsonField::new('spellsPerDay')->hideOnIndex(),
            JsonField::new('knownSpellsPerLevel')->hideOnIndex(),
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
            CollectionField::new('subClasses')->onlyOnDetail(),
        ];
    }
}

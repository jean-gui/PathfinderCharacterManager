<?php

namespace App\Controller\Admin\Rules;

use App\Admin\Field\TranslationField;
use App\Entity\Rules\Abilities;
use App\Entity\Rules\Skill;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SkillCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Skill::class;
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
            TextField::new('shortname'),
            BooleanField::new('untrained'),
            BooleanField::new('armorCheckPenalty'),
            ChoiceField::new('keyAbility')->setChoices(Abilities::ABILITIES),
            TranslationField::new('translations')->onlyOnForms()
        ];
    }
}

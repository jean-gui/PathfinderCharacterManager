<?php

namespace App\Controller\Admin\Rules;

use App\Admin\Field\JsonField;
use App\Admin\Field\TranslationField;
use App\Controller\Admin\GenericCrudController;
use App\Entity\Rules\Spell;
use App\Form\Admin\ClassSpellType;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SpellCrudController extends GenericCrudController
{
    public static function getEntityFqcn(): string
    {
        return Spell::class;
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
            TextField::new('castingTime')->onlyOnDetail(),
            TextField::new('components')->onlyOnDetail(),
            TextField::new('range')->onlyOnDetail(),
            TextField::new('duration')->onlyOnDetail(),
            TextField::new('savingThrow'),
            BooleanField::new('spellResistance'),
            TextField::new('targets')->onlyOnDetail(),
            BooleanField::new('passive'),
            CollectionField::new('classes')
                           ->setEntryIsComplex(true)
                           ->allowAdd(true)
                           ->allowDelete(true)
                           ->setEntryType(ClassSpellType::class),
            JsonField::new('effects')->hideOnIndex(),
            JsonField::new('conditions')->hideOnIndex(),
            JsonField::new('externalConditions')->hideOnIndex(),
            JsonField::new('prerequisities')->hideOnIndex(),
        ];
    }
}

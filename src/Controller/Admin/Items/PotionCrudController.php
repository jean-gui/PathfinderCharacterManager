<?php

namespace App\Controller\Admin\Items;

use App\Entity\Items\Potion;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class PotionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Potion::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $c = parent::configureCrud($crud);

        $searchFields = $c->getAsDto()->getSearchFields();
        $c->setSearchFields(array_merge($searchFields, ['translations.name']));
        $c->addFormTheme('bundles/A2lixTranslationFormBundle/bootstrap_4_layout.html.twig');

        return $c;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('classSpell')
                            ->setFormTypeOption('required', true),
            IntegerField::new('casterLevel')
                        ->setFormTypeOption('required', true),
            IntegerField::new('spellLevel')->onlyOnIndex(),
            BooleanField::new('instantaneous'),
        ];
    }
}

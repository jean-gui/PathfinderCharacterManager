<?php

namespace App\Controller\Admin\Rules;

use App\Admin\Field\JsonField;
use App\Admin\Field\TranslationField;
use App\Controller\Admin\GenericCrudController;
use App\Entity\Items\EquipmentPower;
use App\Entity\Items\ItemPower;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Doctrine\ORM\QueryBuilder;

class ItemPowerCrudController extends GenericCrudController
{
    public static function getEntityFqcn(): string
    {
        return ItemPower::class;
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
            BooleanField::new('passive'),
            JsonField::new('effects')->hideOnIndex(),
            JsonField::new('conditions')->hideOnIndex(),
            JsonField::new('externalConditions')->hideOnIndex(),
            JsonField::new('prerequisities')->hideOnIndex(),
        ];
    }

    protected function addClassRestrictions(QueryBuilder $qb): QueryBuilder
    {
        return $qb->andWhere($qb->expr()->not($qb->expr()->isInstanceOf('entity', EquipmentPower::class)));
    }

    public function createIndexQueryBuilder(
        SearchDto $searchDto,
        EntityDto $entityDto,
        FieldCollection $fields,
        FilterCollection $filters
    ): QueryBuilder {
        $qb = parent::createIndexQueryBuilder(
            $searchDto,
            $entityDto,
            $fields,
            $filters
        );

        return $this->addClassRestrictions($qb);
    }
}

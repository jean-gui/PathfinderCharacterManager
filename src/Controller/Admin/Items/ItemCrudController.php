<?php

namespace App\Controller\Admin\Items;

use App\Admin\Field\TranslationField;
use App\Entity\Items\Armor;
use App\Entity\Items\Belt;
use App\Entity\Items\Body;
use App\Entity\Items\Chest;
use App\Entity\Items\Eyes;
use App\Entity\Items\Feet;
use App\Entity\Items\Hands;
use App\Entity\Items\Head;
use App\Entity\Items\Headband;
use App\Entity\Items\Item;
use App\Entity\Items\Neck;
use App\Entity\Items\Ring;
use App\Entity\Items\Shield;
use App\Entity\Items\Shoulders;
use App\Entity\Items\Weapon;
use App\Entity\Items\Wrists;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Item::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->addFormTheme('bundles/A2lixTranslationFormBundle/bootstrap_4_layout.html.twig');
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
            TranslationField::new('translations')->onlyOnForms(),
            IntegerField::new('cost'),
            NumberField::new('weight'),
            AssociationField::new('powers'),
        ];
    }

    protected function addClassRestrictions(QueryBuilder $qb): QueryBuilder
    {
        $subs = $qb->expr()->orX(
            $qb->expr()->isInstanceOf('entity', Armor::class),
            $qb->expr()->isInstanceOf('entity', Belt::class),
            $qb->expr()->isInstanceOf('entity', Body::class),
            $qb->expr()->isInstanceOf('entity', Chest::class),
            $qb->expr()->isInstanceOf('entity', Eyes::class),
            $qb->expr()->isInstanceOf('entity', Feet::class),
            $qb->expr()->isInstanceOf('entity', Hands::class),
            $qb->expr()->isInstanceOf('entity', Headband::class),
            $qb->expr()->isInstanceOf('entity', Head::class),
            $qb->expr()->isInstanceOf('entity', Neck::class),
            $qb->expr()->isInstanceOf('entity', Ring::class),
            $qb->expr()->isInstanceOf('entity', Shield::class),
            $qb->expr()->isInstanceOf('entity', Shoulders::class),
            $qb->expr()->isInstanceOf('entity', Weapon::class),
            $qb->expr()->isInstanceOf('entity', Wrists::class)
        );

        return $qb->andWhere($qb->expr()->not($subs));
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

<?php

namespace App\Controller\Admin;

use App\Entity\Items\Armor;
use App\Entity\Items\Belt;
use App\Entity\Items\Body;
use App\Entity\Items\Chest;
use App\Entity\Items\EquipmentPower;
use App\Entity\Items\Eyes;
use App\Entity\Items\Feet;
use App\Entity\Items\Hands;
use App\Entity\Items\Head;
use App\Entity\Items\Headband;
use App\Entity\Items\Item;
use App\Entity\Items\ItemPower;
use App\Entity\Items\Neck;
use App\Entity\Items\Potion;
use App\Entity\Items\Ring;
use App\Entity\Items\Shield;
use App\Entity\Items\Shoulders;
use App\Entity\Items\Weapon;
use App\Entity\Items\Wrists;
use App\Entity\Rules\ClassDefinition;
use App\Entity\Rules\ClassPower;
use App\Entity\Rules\CommonPower;
use App\Entity\Rules\Condition;
use App\Entity\Rules\Feat;
use App\Entity\Rules\Race;
use App\Entity\Rules\Skill;
use App\Entity\Rules\Spell;
use App\Entity\Rules\SubClass;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookupInterface;

class DashboardController extends AbstractDashboardController
{
    private $webpack;

    public function __construct(EntrypointLookupInterface $webpack)
    {
        $this->webpack = $webpack;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Pathfinder Character Manager');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linktoDashboard('dashboard', 'fa fa-home'),
            MenuItem::section('users.groups', 'fa fa-user'),
            MenuItem::linkToCrud('users', '', User::class),

            MenuItem::section('rules', 'fa fa-book'),
            MenuItem::linkToCrud('races', '', Race::class),
            MenuItem::linkToCrud('skills', '', Skill::class),
            MenuItem::linkToCrud('feats', '', Feat::class),
            MenuItem::linkToCrud('classes', '', ClassDefinition::class),
            MenuItem::linkToCrud('subclasses', '', SubClass::class),
            MenuItem::linkToCrud('admin.class.powers', '', ClassPower::class),
            MenuItem::linkToCrud('conditions', '', Condition::class),
            MenuItem::linkToCrud('spells', '', Spell::class),
            MenuItem::linkToCrud('item.powers', '', ItemPower::class),
            MenuItem::linkToCrud('equipment.powers', '', EquipmentPower::class),
            MenuItem::linkToCrud('common.powers', '', CommonPower::class),

            MenuItem::section('items', 'fas fa-gift'),
            MenuItem::linkToCrud('items', '', Item::class),
            MenuItem::linkToCrud('weapons', '', Weapon::class),
            MenuItem::linkToCrud('armor', '', Armor::class),
            MenuItem::linkToCrud('ring', '', Ring::class),
            MenuItem::linkToCrud('shield', '', Shield::class),
            MenuItem::linkToCrud('belt', '', Belt::class),
            MenuItem::linkToCrud('eyes', '', Eyes::class),
            MenuItem::linkToCrud('feet', '', Feet::class),
            MenuItem::linkToCrud('hands', '', Hands::class),
            MenuItem::linkToCrud('head', '', Head::class),
            MenuItem::linkToCrud('headband', '', Headband::class),
            MenuItem::linkToCrud('neck', '', Neck::class),
            MenuItem::linkToCrud('shoulders', '', Shoulders::class),
            MenuItem::linkToCrud('wrists', '', Wrists::class),
            MenuItem::linkToCrud('body', '', Body::class),
            MenuItem::linkToCrud('chest', '', Chest::class),
            MenuItem::linkToCrud('potions', '', Potion::class),
        ];
    }

    public function configureAssets(): Assets
    {
        $assets = parent::configureAssets();
        foreach ($this->webpack->getJavaScriptFiles('admin') as $file) {
            $assets->addJsFile($file);
        }
        foreach ($this->webpack->getCssFiles('admin') as $file) {
            $assets->addCssFile($file);
        }

        return $assets;
    }
}

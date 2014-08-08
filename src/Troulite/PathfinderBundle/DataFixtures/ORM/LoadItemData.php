<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Troulite\PathfinderBundle\Entity\Amulet;
use Troulite\PathfinderBundle\Entity\Armor;
use Troulite\PathfinderBundle\Entity\Belt;
use Troulite\PathfinderBundle\Entity\Boots;
use Troulite\PathfinderBundle\Entity\Bracers;
use Troulite\PathfinderBundle\Entity\Cloak;
use Troulite\PathfinderBundle\Entity\Gloves;
use Troulite\PathfinderBundle\Entity\Helm;
use Troulite\PathfinderBundle\Entity\Item;
use Troulite\PathfinderBundle\Entity\ItemPower;
use Troulite\PathfinderBundle\Entity\Ring;
use Troulite\PathfinderBundle\Entity\Shield;
use Troulite\PathfinderBundle\Entity\Weapon;

/**
 * Class LoadItemData
 *
 * @package Troulite\PathfinderBundle\DataFixtures\ORM
 */
class LoadItemData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $finder = new Finder();
        $finder->files()->in('src/Troulite/PathfinderBundle/DataFixtures/ORM/')->name('magic_items.csv');
        /** @var $file SplFileInfo */
        foreach($finder as $file) {
            $handle = fopen($file->getRealPath(), 'r');
            $header = null;
            while (($row = fgetcsv($handle, null, ',', '"', "\\")) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data = array_combine($header, $row);

                    switch($data['Slot']) {
                        case 'weapon':
                            $item = new Weapon();
                            $item->setCategory('');
                            $item->setType('');
                            $item->setDualWield(false);
                            $item->setDamages('');
                            $item->setCritical('');
                            $item->setCriticalRange('');
                            break;
                        case 'body':
                        case 'armor':
                        case 'chest':
                            $item = new Armor();
                            $item->setAc(0);
                            $item->setCategory('');
                            $item->setArcaneSpellFailure(0);
                            $item->setArmorCheckPenalty(0);
                            $item->setMaximumDexterityBonus(0);
                            break;
                        case 'ring':
                            $item = new Ring();
                            break;
                        case 'neck':
                        case 'amulet':
                            $item = new Amulet();
                            break;
                        case 'feet':
                            $item = new Boots();
                            break;
                        case 'arms':
                            $item = new Bracers();
                            break;
                        case 'hands':
                            if ($data['Group'] === 'Weapon') {
                                $item = new Weapon();
                                $item->setCategory('');
                                $item->setType('');
                                $item->setDualWield(false);
                                $item->setDamages('');
                                $item->setCritical('');
                                $item->setCriticalRange('');
                            } else {
                                $item = new Gloves();
                            }
                            break;
                        case 'head':
                        case 'headband':
                            $item = new Helm();
                            break;
                        case 'shoulders':
                            $item = new Cloak();
                            break;
                        case 'shield':
                            $item = new Shield();
                            $item->setAc(0);
                            break;
                        case 'belt':
                            $item = new Belt();
                            break;
                        default:
                            $item = new Item();
                    }

                    $item
                        ->setName($data['Name'])
                        ->setShortDescription($data['Description'])
                        ->setCost($data['Price']);

                    $weight = preg_replace('/ lb.*/', '', $data['Weight']);
                    $weight = (is_numeric($weight) ? $weight : 0);
                    $item->setWeight($weight);

                    if ($data['effects']) {
                        $power = new ItemPower();
                        $power->setEffects(json_decode($data['effects']));
                        $item->addPower($power);
                    }
                    $manager->persist($item);
                }
            }
        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 1;
    }
}
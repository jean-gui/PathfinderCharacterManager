<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Gedmo\Translatable\Entity\Repository\TranslationRepository;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Troulite\PathfinderBundle\Entity\Feat;

/**
 * Class LoadFeatData
 *
 * @package Troulite\PathfinderBundle\DataFixtures\ORM
 */
class
LoadFeatData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        /** @var $translationsRepository TranslationRepository */
        $translationsRepository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        $finder = new Finder();
        $finder->files()->in('src/Troulite/PathfinderBundle/Resources/data/')->name('dons.csv');
        /** @var $file SplFileInfo */
        foreach($finder as $file) {
            $handle = fopen($file->getRealPath(), 'r');
            $header = null;
            while (($row = fgetcsv($handle, null, ',', '"', "\\")) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data = array_combine($header, $row);
                    if (!in_array($data['source'], array('PFRPG Core', "Advanced Player's Guide", 'Bestiary'))) {
                        continue;
                    }

                    $feat = new Feat();
                    $feat
                        ->setName($data['name'])
                        ->setShortDescription($data['description'])
                        ->setLongDescription($data['benefit'])
                        ->setPassive($data['passive']);
                    if ($data['effects']) {
                        $feat->setEffects(json_decode($data['effects']));
                    }
                    if ($data['conditions']) {
                        $feat->setConditions(json_decode($data['conditions']));
                    }
                    if ($data['external_conditions']) {
                        $feat->setExternalConditions(json_decode($data['external_conditions']));
                    }
                    $manager->persist($feat);
                    if ($data['name_fr'] && $data['name_fr'] != '#N/D') {
                        $translationsRepository->translate($feat, 'name', 'fr', $data['name_fr']);
                    }
                    if ($data['description_fr'] && $data['description_fr'] != '#N/D') {
                        $translationsRepository->translate($feat, 'shortDescription', 'fr', $data['description_fr']);
                    }
                    if ($data['benefit_fr'] && $data['benefit_fr'] != '#N/D') {
                        $translationsRepository->translate($feat, 'longDescription', 'fr', $data['benefit_fr']);
                    }

                    $this->addReference('feat - ' . $feat->getName(), $feat);
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
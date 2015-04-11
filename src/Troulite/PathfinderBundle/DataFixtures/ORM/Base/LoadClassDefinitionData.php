<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM\Base;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Gedmo\Translatable\Entity\Repository\TranslationRepository;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Troulite\PathfinderBundle\Entity\ClassDefinition;
use Troulite\PathfinderBundle\Entity\ClassPower;

/**
 * Class LoadClassDefinitionData
 *
 * @package Troulite\PathfinderBundle\DataFixtures\ORM\Base
 */
class LoadClassDefinitionData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /** @var $translationsRepository TranslationRepository */
        $translationsRepository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        $finder = new Finder();
        $finder->files()->in('src/Troulite/PathfinderBundle/Resources/data/')->name('pouvoirs.csv');

        $powers = array();
        /** @var $file SplFileInfo */
        foreach ($finder as $file) {
            $handle = fopen($file->getRealPath(), 'r');
            $header = null;
            while (($row = fgetcsv($handle, null, ',', '"', "\\")) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data                  = array_combine($header, $row);
                    $powers[$data['name']] = $data;
                }
            }
        }

        $bab       = array();
        $reflexes  = array();
        $fortitude = array();
        $will      = array();
        for ($i = 0; $i < 20; $i++) {
            $bab[]       = $i + 1;
            $reflexes[]  = ((int)(($i + 1) / 2)) + 2;
            $fortitude[] = ((int)(($i + 1) / 2)) + 2;
            $will[]      = (int)(($i + 1) / 3);
        }
        $spellsPerDay = array(
            1 => array(-1, -1, -1, 0, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 3, 4, 4, 4, 4),
            2 => array(-1, -1, -1, -1, -1, -1, 0, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 3, 4),
            3 => array(-1, -1, -1, -1, -1, -1, -1, -1, -1, 0, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3),
            4 => array(-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 0, 1, 1, 1, 1, 2, 2, 3)
        );

        $ranger = new ClassDefinition();
        /** @noinspection PhpParamsInspection */
        $ranger
            ->setName("Ranger")
            ->setHpDice(10)
            ->setSkillPoints(6)
            ->setBab($bab)
            ->setReflexes($reflexes)
            ->setFortitude($fortitude)
            ->setWill($will)
            ->setSpellsPerDay($spellsPerDay)
            ->setCastingAbility('wisdom')
            ->setPreparationNeeded(true)
            ->addClassSkill($this->getReference('climb'))
            ->addClassSkill($this->getReference('craft'))
            ->addClassSkill($this->getReference('handleAnimal'))
            ->addClassSkill($this->getReference('heal'))
            ->addClassSkill($this->getReference('intimidate'))
            ->addClassSkill($this->getReference('knowledgeDungeoneering'))
            ->addClassSkill($this->getReference('knowledgeGeography'))
            ->addClassSkill($this->getReference('knowledgeNature'))
            ->addClassSkill($this->getReference('perception'))
            ->addClassSkill($this->getReference('profession'))
            ->addClassSkill($this->getReference('ride'))
            ->addClassSkill($this->getReference('spellcraft'))
            ->addClassSkill($this->getReference('stealth'))
            ->addClassSkill($this->getReference('survival'))
            ->addClassSkill($this->getReference('swim'));

        $power = (new ClassPower())
            ->setName('Favored Enemy (+2) (Ex)')
            ->setLevel(1)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    'melee-attack-roll'  => array('type' => 'favored-enemy', 'value' => 2),
                    'melee-damage-roll'  => array('type' => 'favored-enemy', 'value' => 2),
                    'ranged-attack-roll' => array('type' => 'favored-enemy', 'value' => 2),
                    'ranged-damage-roll' => array('type' => 'favored-enemy', 'value' => 2),
                    'bluff'              => array('type' => 'favored-enemy', 'value' => 2),
                    'perception'         => array('type' => 'favored-enemy', 'value' => 2),
                    'sense-motive'       => array('type' => 'favored-enemy', 'value' => 2),
                    'survival'           => array('type' => 'favored-enemy', 'value' => 2),
                )
            );
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $ranger->addPower($power);
        $this->setReference('favored-enemy-1', $power);

        $power = (new ClassPower())
            ->setName('Track (Ex)')
            ->setLevel(1)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    // 1 == ranger class id
                    'survival' => array('type' => null, 'value' => 'max(1, div(c.getLevel(1), 2))'),
                )
            );
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $ranger->addPower($power);
        $this->setReference('track', $power);

        $power = (new ClassPower())
            ->setName('Wild Empathy (Ex)')
            ->setLevel(1)
            ->setClass($ranger)
            ->setPassive(false);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $ranger->addPower($power);
        $this->setReference('wild-empathy', $power);

        $power = (new ClassPower())
            ->setName('Combat Style (Ex)')
            ->setLevel(2)
            ->setClass($ranger)
            ->setPassive(true)
            ->setEffects(
                array(
                    'choice' => array('Archery', 'Two-weapon')
                )
            );
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $ranger->addPower($power);
        $this->setReference('combat-style', $power);

        $power = (new ClassPower())
            ->setName('First Combat Style Feat (Ex)')
            ->setLevel(2)
            ->setClass($ranger)
            ->setPassive(true)
            ->setEffects(
                array(
                    'feat' => [
                        'type'  => 'oneof',
                        'value' => array('Far Shot', 'Point Blank Shot', 'Precise Shot', 'Rapid Shot')
                    ]
                )
            )
            ->setPrerequisities(
                array(
                    'class-power' => '
                        classPower.getClassPower().getName() === "Combat Style" &&
                        classPower.getExtraInformation() === "Archery"
                    '
                )
            );
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $ranger->addPower($power);
        $this->setReference('combat-style-feat-1', $power);

        $power = (new ClassPower())
            ->setName('First Combat Style Feat (Ex)')
            ->setLevel(2)
            ->setClass($ranger)
            ->setPassive(true)
            ->setEffects(
                array(
                    'feat' => [
                        'type'  => 'oneof',
                        'value' => array('Double Slice', 'Improved Shield Bash', 'Quick Draw', 'Two-Weapon Fighting')
                    ]
                )
            )
            ->setPrerequisities(
                array(
                    'class-power' => '
                        classPower.getClassPower().getName() === "Combat Style" &&
                        classPower.getExtraInformation() === "Two-Weapon"
                    '
                )
            );
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $ranger->addPower($power);

        $power = (new ClassPower())
            ->setName('Endurance')
            ->setLevel(3)
            ->setClass($ranger)
            ->setPassive(true)
            ->setEffects(
                array('feat' => ['type' => null, 'value' => 'Endurance'])
            );
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $ranger->addPower($power);
        $this->setReference('endurance', $power);

        $power = (new ClassPower())
            ->setName('Favored Terrain +2 (Ex)')
            ->setLevel(3)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    'initiative'          => array('type' => null, 'value' => 2),
                    'knowledge-geography' => array('type' => null, 'value' => 2),
                    'perception'          => array('type' => null, 'value' => 2),
                    'stealth'             => array('type' => null, 'value' => 2),
                    'survival'            => array('type' => null, 'value' => 2),
                )
            );
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $ranger->addPower($power);
        $this->setReference('favored-terrain-1', $power);

        $power = (new ClassPower())
            ->setName("Hunter's Bond (Ex)")
            ->setLevel(4)
            ->setClass($ranger)
            ->setPassive(false);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $ranger->addPower($power);
        $this->setReference('hunter-bond', $power);

        $power = (new ClassPower())
            ->setName('Favored Enemy (+4) (Ex)')
            ->setLevel(5)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    'melee-attack-roll'  => array('type' => 'favored-enemy', 'value' => 4),
                    'melee-damage-roll'  => array('type' => 'favored-enemy', 'value' => 4),
                    'ranged-attack-roll' => array('type' => 'favored-enemy', 'value' => 4),
                    'ranged-damage-roll' => array('type' => 'favored-enemy', 'value' => 4),
                    'bluff'              => array('type' => 'favored-enemy', 'value' => 4),
                    'perception'         => array('type' => 'favored-enemy', 'value' => 4),
                    'sense-motive'       => array('type' => 'favored-enemy', 'value' => 4),
                    'survival'           => array('type' => 'favored-enemy', 'value' => 4),
                )
            );
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $ranger->addPower($power);
        $this->setReference('favored-enemy-2', $power);

        $power = (new ClassPower())
            ->setName('Second Combat Style Feat (Ex)')
            ->setLevel(6)
            ->setClass($ranger)
            ->setPassive(true)
            ->setEffects(
                array(
                    'feat' => [
                        'type'  => 'oneof',
                        'value' => array(
                            'Far Shot',
                            'Point Blank Shot',
                            'Precise Shot',
                            'Rapid Shot',
                            'Improved Precise Shot',
                            'Manyshot'

                        )
                    ]
                )
            )
            ->setPrerequisities(
                array(
                    'class-power' => '
                        classPower.getClassPower().getName() === "Combat Style" &&
                        classPower.getExtraInformation() === "Archery"
                    '
                )
            );
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $ranger->addPower($power);
        $this->setReference('combat-style-feat-2', $power);

        $power = (new ClassPower())
            ->setName('Second Combat Style Feat (Ex)')
            ->setLevel(6)
            ->setClass($ranger)
            ->setPassive(true)
            ->setEffects(
                array(
                    'feat' => [
                        'type'  => 'oneof',
                        'value' => array(
                            'Double Slice',
                            'Improved Shield Bash',
                            'Quick Draw',
                            'Two-Weapon Fighting',
                            'Improved Two-Weapon Fighting',
                            'Two-Weapon Defense'
                        )
                    ]
                )
            )
            ->setPrerequisities(
                array(
                    'class-power' => '
                        classPower.getClassPower().getName() === "Combat Style" &&
                        classPower.getExtraInformation() === "Two-Weapon"
                    '
                )
            );
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $ranger->addPower($power);

        $power = (new ClassPower())
            ->setName('Woodland Stride (Ex)')
            ->setLevel(7)
            ->setClass($ranger)
            ->setPassive(true);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $ranger->addPower($power);
        $this->setReference('woodland-stride', $power);

        $power = (new ClassPower())
            ->setName('Swift Tracker (Ex)')
            ->setLevel(8)
            ->setClass($ranger)
            ->setPassive(false);
        $ranger->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->setReference('swift-tracker', $power);

        $power = (new ClassPower())
            ->setName('Favored Terrain +4 (Ex)')
            ->setLevel(8)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    'initiative'          => array('type' => null, 'value' => 4),
                    'knowledge-geography' => array('type' => null, 'value' => 4),
                    'perception'          => array('type' => null, 'value' => 4),
                    'stealth'             => array('type' => null, 'value' => 4),
                    'survival'            => array('type' => null, 'value' => 4),
                )
            );
        $ranger->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->setReference('favored-terrain-2', $power);

        $power = (new ClassPower())
            ->setName('Evasion (Ex)')
            ->setLevel(9)
            ->setClass($ranger)
            ->setPassive(true);
        $ranger->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->setReference('evasion', $power);

        $power = (new ClassPower())
            ->setName('Third Combat Style Feat (Ex)')
            ->setLevel(10)
            ->setClass($ranger)
            ->setPassive(true)
            ->setEffects(
                array(
                    'feat' => [
                        'type'  => 'oneof',
                        'value' => array(
                            'Far Shot',
                            'Point Blank Shot',
                            'Precise Shot',
                            'Rapid Shot',
                            'Improved Precise Shot',
                            'Manyshot',
                            'Pinpoint Targeting',
                            'Shot on the Run'
                        )
                    ]
                )
            )
            ->setPrerequisities(
                array(
                    'class-power' => '
                        classPower.getClassPower().getName() === "Combat Style" &&
                        classPower.getExtraInformation() === "Archery"
                    '
                )
            );
        $ranger->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->setReference('combat-style-feat-3', $power);

        $power = (new ClassPower())
            ->setName('Third Combat Style Feat (Ex)')
            ->setLevel(10)
            ->setClass($ranger)
            ->setPassive(true)
            ->setEffects(
                array(
                    'feat' => [
                        'type'  => 'oneof',
                        'value' => array(
                            'Double Slice',
                            'Improved Shield Bash',
                            'Quick Draw',
                            'Two-Weapon Fighting',
                            'Improved Two-Weapon Fighting',
                            'Two-Weapon Defense',
                            'Greater Two-Weapon Fighting',
                            'Two-Weapon Rend'
                        )
                    ]
                )
            )
            ->setPrerequisities(
                array(
                    'class-power' => '
                        classPower.getClassPower().getName() === "Combat Style" &&
                        classPower.getExtraInformation() === "Two-Weapon"
                    '
                )
            );
        $ranger->addPower($power);

        $power = (new ClassPower())
            ->setName('Favored Enemy (+6) (Ex)')
            ->setLevel(10)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    'melee-attack-roll'  => array('type' => 'favored-enemy', 'value' => 6),
                    'melee-damage-roll'  => array('type' => 'favored-enemy', 'value' => 6),
                    'ranged-attack-roll' => array('type' => 'favored-enemy', 'value' => 6),
                    'ranged-damage-roll' => array('type' => 'favored-enemy', 'value' => 6),
                    'bluff'              => array('type' => 'favored-enemy', 'value' => 6),
                    'perception'         => array('type' => 'favored-enemy', 'value' => 6),
                    'sense-motive'       => array('type' => 'favored-enemy', 'value' => 6),
                    'survival'           => array('type' => 'favored-enemy', 'value' => 6),
                )
            );
        $ranger->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->setReference('favored-enemy-3', $power);

        $power = (new ClassPower())
            ->setName('Quarry')
            ->setLevel(11)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    'ranged-attack-roll' => array('type' => null, 'value' => 2),
                    'melee-attack-roll'  => array('type' => null, 'value' => 2),
                )
            );
        $ranger->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->setReference('quarry', $power);

        $power = (new ClassPower())
            ->setName('Camouflage (Ex)')
            ->setLevel(12)
            ->setClass($ranger)
            ->setPassive(true);
        $ranger->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->setReference('camouflage', $power);

        $power = (new ClassPower())
            ->setName('Favored Terrain +6 (Ex)')
            ->setLevel(13)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    'initiative'          => array('type' => null, 'value' => 6),
                    'knowledge-geography' => array('type' => null, 'value' => 6),
                    'perception'          => array('type' => null, 'value' => 6),
                    'stealth'             => array('type' => null, 'value' => 6),
                    'survival'            => array('type' => null, 'value' => 6),
                )
            );
        $ranger->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->setReference('favored-terrain-3', $power);

        $power = (new ClassPower())
            ->setName('Fourth Combat Style Feat (Ex)')
            ->setLevel(14)
            ->setClass($ranger)
            ->setPassive(true)
            ->setEffects(
                array(
                    'feat' => [
                        'type'  => 'oneof',
                        'value' => array(
                            'Far Shot',
                            'Point Blank Shot',
                            'Precise Shot',
                            'Rapid Shot',
                            'Improved Precise Shot',
                            'Manyshot',
                            'Pinpoint Targeting',
                            'Shot on the Run'
                        )
                    ]
                )
            )
            ->setPrerequisities(
                array(
                    'class-power' => '
                        classPower.getClassPower().getName() === "Combat Style" &&
                        classPower.getExtraInformation() === "Archery"
                    '
                )
            );
        $ranger->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->setReference('combat-style-feat-4', $power);

        $power = (new ClassPower())
            ->setName('Fourth Combat Style Feat (Ex)')
            ->setLevel(14)
            ->setClass($ranger)
            ->setPassive(true)
            ->setEffects(
                array(
                    'feat' => [
                        'type'  => 'oneof',
                        'value' => array(
                            'Double Slice',
                            'Improved Shield Bash',
                            'Quick Draw',
                            'Two-Weapon Fighting',
                            'Improved Two-Weapon Fighting',
                            'Two-Weapon Defense',
                            'Greater Two-Weapon Fighting',
                            'Two-Weapon Rend'
                        )
                    ]
                )
            )
            ->setPrerequisities(
                array(
                    'class-power' => '
                        classPower.getClassPower().getName() === "Combat Style" &&
                        classPower.getExtraInformation() === "Two-Weapon"
                    '
                )
            );
        $ranger->addPower($power);

        $power = (new ClassPower())
            ->setName('Favored Enemy (+8) (Ex)')
            ->setLevel(15)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    'melee-attack-roll'  => array('type' => 'favored-enemy', 'value' => 8),
                    'melee-damage-roll'  => array('type' => 'favored-enemy', 'value' => 8),
                    'ranged-attack-roll' => array('type' => 'favored-enemy', 'value' => 8),
                    'ranged-damage-roll' => array('type' => 'favored-enemy', 'value' => 8),
                    'bluff'              => array('type' => 'favored-enemy', 'value' => 8),
                    'perception'         => array('type' => 'favored-enemy', 'value' => 8),
                    'sense-motive'       => array('type' => 'favored-enemy', 'value' => 8),
                    'survival'           => array('type' => 'favored-enemy', 'value' => 8),
                )
            );
        $ranger->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->setReference('favored-enemy-4', $power);

        $power = (new ClassPower())
            ->setName('Improved Evasion (Ex)')
            ->setLevel(16)
            ->setClass($ranger)
            ->setPassive(true);
        $ranger->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->setReference('improved-evasion', $power);

        $power = (new ClassPower())
            ->setName('Hide in Plain Sight (Ex)')
            ->setLevel(17)
            ->setClass($ranger)
            ->setPassive(false);
        $ranger->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->setReference('hide-in-plain-sight', $power);

        $power = (new ClassPower())
            ->setName('Fifth Combat Style Feat (Ex)')
            ->setLevel(18)
            ->setClass($ranger)
            ->setPassive(true)
            ->setEffects(
                array(
                    'feat' => [
                        'type'  => 'oneof',
                        'value' => array(
                            'Far Shot',
                            'Point Blank Shot',
                            'Precise Shot',
                            'Rapid Shot',
                            'Improved Precise Shot',
                            'Manyshot',
                            'Pinpoint Targeting',
                            'Shot on the Run'
                        )
                    ]
                )
            )
            ->setPrerequisities(
                array(
                    'class-power' => '
                        classPower.getClassPower().getName() === "Combat Style" &&
                        classPower.getExtraInformation() === "Archery"
                    '
                )
            );
        $ranger->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->setReference('combat-style-feat-5', $power);

        $power = (new ClassPower())
            ->setName('Fifth Combat Style Feat (Ex)')
            ->setLevel(18)
            ->setClass($ranger)
            ->setPassive(true)
            ->setEffects(
                array(
                    'feat' => [
                        'type'  => 'oneof',
                        'value' => array(
                            'Double Slice',
                            'Improved Shield Bash',
                            'Quick Draw',
                            'Two-Weapon Fighting',
                            'Improved Two-Weapon Fighting',
                            'Two-Weapon Defense',
                            'Greater Two-Weapon Fighting',
                            'Two-Weapon Rend'
                        )
                    ]
                )
            )
            ->setPrerequisities(
                array(
                    'class-power' => '
                        classPower.getClassPower().getName() === "Combat Style" &&
                        classPower.getExtraInformation() === "Two-Weapon"
                    '
                )
            );
        $ranger->addPower($power);

        $power = (new ClassPower())
            ->setName('Favored Terrain +8 (Ex)')
            ->setLevel(18)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    'initiative'          => array('type' => null, 'value' => 8),
                    'knowledge-geography' => array('type' => null, 'value' => 8),
                    'perception'          => array('type' => null, 'value' => 8),
                    'stealth'             => array('type' => null, 'value' => 8),
                    'survival'            => array('type' => null, 'value' => 8),
                )
            );
        $ranger->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->setReference('favored-terrain-4', $power);

        $power = (new ClassPower())
            ->setName('Improved Quarry (Ex)')
            ->setLevel(19)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    'ranged-attack-roll' => array('type' => null, 'value' => 4),
                    'melee-attack-roll'  => array('type' => null, 'value' => 4),
                )
            );
        $ranger->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->setReference('improved-quarry', $power);

        $power = (new ClassPower())
            ->setName('Master Hunter (Ex)')
            ->setLevel(20)
            ->setClass($ranger)
            ->setPassive(false);
        $ranger->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->setReference('master-hunter', $power);

        /**
         * @todo Missing knowledge bonus
         */
        $power = (new ClassPower())
            ->setName('Favored Enemy (+10) (Ex)')
            ->setLevel(20)
            ->setClass($ranger)
            ->setPassive(false)
            ->setEffects(
                array(
                    'melee-attack-roll'  => array('type' => 'favored-enemy', 'value' => 10),
                    'melee-damage-roll'  => array('type' => 'favored-enemy', 'value' => 10),
                    'ranged-attack-roll' => array('type' => 'favored-enemy', 'value' => 10),
                    'ranged-damage-roll' => array('type' => 'favored-enemy', 'value' => 10),
                    'bluff'              => array('type' => 'favored-enemy', 'value' => 10),
                    'perception'         => array('type' => 'favored-enemy', 'value' => 10),
                    'sense-motive'       => array('type' => 'favored-enemy', 'value' => 10),
                    'survival'           => array('type' => 'favored-enemy', 'value' => 10),
                )
            );
        $ranger->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->setReference('favored-enemy-4', $power);

        $manager->persist($ranger);
        $manager->flush();

        $this->addReference('ranger', $ranger);

        $bab       = array();
        $reflexes  = array();
        $fortitude = array();
        $will      = array();
        for ($i = 0; $i < 20; $i++) {
            $bab[]       = $i + 1;
            $reflexes[]  = (int)(($i + 1) / 3);
            $fortitude[] = ((int)(($i + 1) / 2)) + 2;
            $will[]      = (int)(($i + 1) / 3);
        }

        $barbarian = new ClassDefinition();
        /** @noinspection PhpParamsInspection */
        $barbarian
            ->setName("Barbarian")
            ->setHpDice(12)
            ->setSkillPoints(4)
            ->setBab($bab)
            ->setReflexes($reflexes)
            ->setFortitude($fortitude)
            ->setWill($will)
            ->addClassSkill($this->getReference('climb'))
            ->addClassSkill($this->getReference('craft'))
            ->addClassSkill($this->getReference('handleAnimal'))
            ->addClassSkill($this->getReference('acrobatics'))
            ->addClassSkill($this->getReference('intimidate'))
            ->addClassSkill($this->getReference('knowledgeNature'))
            ->addClassSkill($this->getReference('perception'))
            ->addClassSkill($this->getReference('ride'))
            ->addClassSkill($this->getReference('survival'))
            ->addClassSkill($this->getReference('swim'));

        $power = (new ClassPower())
            ->setName('Fast Movement (Ex)')
            ->setLevel(1)
            ->setClass($barbarian)
            ->setPassive(true);
        $barbarian->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('fast-movement', $power);

        $power = (new ClassPower())
            ->setName('Rage (Ex)')
            ->setLevel(1)
            ->setClass($barbarian)
            ->setPassive(false)
            ->setEffects(
                array(
                    'strength'     => ['type' => 'morale', 'value' => 4],
                    'constitution' => ['type' => 'morale', 'value' => 4],
                    'will'         => ['type' => 'morale', 'value' => 2],
                    'ac'           => ['type' => null, 'value' => -2],
                )
            );
        $barbarian->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('rage', $power);

        $power = (new ClassPower())
            ->setName('Uncanny Dodge (Ex)')
            ->setLevel(2)
            ->setClass($barbarian)
            ->setPassive(true);
        $barbarian->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('uncanny-dodge', $power);

        $power = (new ClassPower())
            ->setName('Trap Sense (Ex)')
            ->setLevel(3)
            ->setClass($barbarian)
            ->setPassive(true);
        $barbarian->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('trap-sense', $power);

        $power = (new ClassPower())
            ->setName('Improved Uncanny Dodge (Ex)')
            ->setLevel(5)
            ->setClass($barbarian)
            ->setPassive(true);
        $barbarian->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('improved-uncanny-dodge', $power);

        $power = (new ClassPower())
            ->setName('Damage Reduction (Ex)')
            ->setLevel(7)
            ->setClass($barbarian)
            ->setPassive(true)
            ->setEffects(
                array(
                    'damage-reduction' => ['type' => null, 'value' => 'div(c.getLevel(2), 3) - 1']
                )
            );
        $barbarian->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('damage-reduction', $power);

        $power = (new ClassPower())
            ->setName('Greater Rage (Ex)')
            ->setLevel(11)
            ->setClass($barbarian)
            ->setPassive(true)
            ->setEffects(
                array(
                    'strength'     => ['type' => 'morale', 'value' => 6],
                    'constitution' => ['type' => 'morale', 'value' => 6],
                    'will'         => ['type' => 'morale', 'value' => 3],
                )
            )
            ->setExternalConditions(
                array('active-power' => 'rage')
            );
        $barbarian->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('Greater Rage', $power);

        $power = (new ClassPower())
            ->setName('Indomitable Will (Ex)')
            ->setLevel(14)
            ->setClass($barbarian)
            ->setPassive(true)
            ->setEffects(
                array(
                    'saving-enchantment' => ['type' => null, 'value' => 4]
                )
            )
            ->setExternalConditions(
                array('active-power' => 'rage')
            );
        $barbarian->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('indomitable-will', $power);

        $power = (new ClassPower())
            ->setName('Tireless Rage (Ex)')
            ->setLevel(17)
            ->setClass($barbarian)
            ->setPassive(true)
            ->setExternalConditions(
                array('active-power' => 'rage')
            );
        $barbarian->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('tireless-rage', $power);

        $power = (new ClassPower())
            ->setName('Mighty Rage (Ex)')
            ->setLevel(20)
            ->setClass($barbarian)
            ->setPassive(false)
            ->setEffects(
                array(
                    'strength'     => ['type' => 'morale', 'value' => 8],
                    'constitution' => ['type' => 'morale', 'value' => 8],
                    'will'         => ['type' => 'morale', 'value' => 4],
                )
            )
            ->setExternalConditions(
                array('active-power' => 'rage')
            );
        $barbarian->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('mighty-rage', $power);

        $manager->persist($barbarian);
        $manager->flush();

        $this->addReference('barbarian', $barbarian);

        $bab       = array();
        $reflexes  = array();
        $fortitude = array();
        $will      = array();
        for ($i = 0; $i < 20; $i++) {
            $bab[]       = $i + 1;
            $reflexes[]  = ((int)(($i + 1) / 3));
            $fortitude[] = ((int)(($i + 1) / 2)) + 2;
            $will[]      = (int)(($i + 1) / 2) + 2;
        }
        $spellsPerDay = array(
            1 => array(-1, -1, -1, 0, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 3, 4, 4, 4, 4),
            2 => array(-1, -1, -1, -1, -1, -1, 0, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 3, 4),
            3 => array(-1, -1, -1, -1, -1, -1, -1, -1, -1, 0, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3),
            4 => array(-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 0, 1, 1, 1, 1, 2, 2, 3)
        );

        $paladin = new ClassDefinition();
        /** @noinspection PhpParamsInspection */
        $paladin
            ->setName("Paladin")
            ->setHpDice(10)
            ->setSkillPoints(2)
            ->setBab($bab)
            ->setReflexes($reflexes)
            ->setFortitude($fortitude)
            ->setWill($will)
            ->setSpellsPerDay($spellsPerDay)
            ->setCastingAbility('charisma')
            ->setPreparationNeeded(true)
            ->addClassSkill($this->getReference('craft'))
            ->addClassSkill($this->getReference('diplomacy'))
            ->addClassSkill($this->getReference('handleAnimal'))
            ->addClassSkill($this->getReference('heal'))
            ->addClassSkill($this->getReference('knowledgeNobility'))
            ->addClassSkill($this->getReference('knowledgeReligion'))
            ->addClassSkill($this->getReference('profession'))
            ->addClassSkill($this->getReference('ride'))
            ->addClassSkill($this->getReference('senseMotive'))
            ->addClassSkill($this->getReference('spellcraft'));

        $power = (new ClassPower())
            ->setName('Aura of Good (Ex)')
            ->setLevel(1)
            ->setClass($paladin)
            ->setPassive(false);
        $paladin->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('aura-of-good', $power);

        $power = (new ClassPower())
            ->setName('Detect Evil')
            ->setLevel(1)
            ->setClass($paladin)
            ->setPassive(false);
        $paladin->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('detect-evil', $power);

        $power = (new ClassPower())
            ->setName('Smite Evil (Su)')
            ->setLevel(1)
            ->setClass($paladin)
            ->setPassive(false)
            ->setEffects(
                array(
                    'melee-attack-roll'  => [
                        'type'  => null,
                        'value' => 'max(0, c.getAbilityModifier(c.getCharisma()))'
                    ],
                    'ranged-attack-roll' => [
                        'type'  => null,
                        'value' => 'max(0, c.getAbilityModifier(c.getCharisma()))'
                    ],
                    'melee-damage-roll'  => ['type' => null, 'value' => 'c.getLevel(3)'],
                    'ranged-damage-roll' => ['type' => null, 'value' => 'c.getLevel(3)'],
                    'ac'                 => [
                        'type'  => 'deflection',
                        'value' => 'max(0, c.getAbilityModifier(c.getCharisma()))'
                    ]
                )
            );
        $paladin->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('smite-evil', $power);

        $power = (new ClassPower())
            ->setName('Divine Grace (Su)')
            ->setShortDescription(
                'At 2nd level, a paladin gains a bonus equal to her Charisma bonus (if any) on all Saving Throws.'
            )
            ->setLevel(2)
            ->setClass($paladin)
            ->setPassive(true)
            ->setEffects(
                array(
                    'fortitude' => array('type' => null, 'value' => 'max(0, c.getAbilityModifier(c.getCharisma()))'),
                    'reflexes'  => array('type' => null, 'value' => 'max(0, c.getAbilityModifier(c.getCharisma()))'),
                    'will'      => array('type' => null, 'value' => 'max(0, c.getAbilityModifier(c.getCharisma()))')
                )
            );
        $paladin->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('divine-grace', $power);

        $power = (new ClassPower())
            ->setName('Lay On Hands (Su)')
            ->setLevel(2)
            ->setClass($paladin)
            ->setPassive(false);
        $paladin->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('lay-on-hands', $power);

        $power = (new ClassPower())
            ->setName('Aura of Courage (Su)')
            ->setLevel(3)
            ->setClass($paladin)
            ->setPassive(true);
        $paladin->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('aura-of-courage', $power);

        $power = (new ClassPower())
            ->setName('Divine Health (Ex)')
            ->setLevel(3)
            ->setClass($paladin)
            ->setPassive(false);
        $paladin->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('divine-health', $power);

        $power = (new ClassPower())
            ->setName('First Mercy (Su)')
            ->setLevel(3)
            ->setClass($paladin)
            ->setPassive(true);
        $paladin->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('mercy-1', $power);

        $power = (new ClassPower())
            ->setName('Channel Positive Energy (Su)')
            ->setLevel(4)
            ->setClass($paladin)
            ->setPassive(false);
        $paladin->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('channel-positive-energy', $power);

        $power = (new ClassPower())
            ->setName('Divine Bond (Sp)')
            ->setLevel(5)
            ->setClass($paladin)
            ->setPassive(false);
        $paladin->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('divine-bond', $power);

        $power = (new ClassPower())
            ->setName('Second Mercy (Su)')
            ->setLevel(6)
            ->setClass($paladin)
            ->setPassive(true);
        $paladin->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('mercy-2', $power);

        $power = (new ClassPower())
            ->setName('Aura of Resolve (Su)')
            ->setLevel(8)
            ->setClass($paladin)
            ->setPassive(true);
        $paladin->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('aura-of-resolve', $power);

        $power = (new ClassPower())
            ->setName('Third Mercy (Su)')
            ->setLevel(9)
            ->setClass($paladin)
            ->setPassive(true);
        $paladin->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('mercy-3', $power);

        $power = (new ClassPower())
            ->setName('Aura of Justice (Su)')
            ->setLevel(11)
            ->setClass($paladin)
            ->setCastable(true)
            ->setPassive(false)
            ->setEffects(
                array(
                    'melee-attack-roll'  => [
                        'type'  => null,
                        'value' => 'max(0, caster.getAbilityModifier(caster.getCharisma()))'
                    ],
                    'ranged-attack-roll' => [
                        'type'  => null,
                        'value' => 'max(0, caster.getAbilityModifier(caster.getCharisma()))'
                    ],
                    'melee-damage-roll'  => ['type' => null, 'value' => 'caster.getLevel(3)'],
                    'ranged-damage-roll' => ['type' => null, 'value' => 'caster.getLevel(3)'],
                    'ac'                 => [
                        'type'  => 'deflection',
                        'value' => 'max(0, caster.getAbilityModifier(caster.getCharisma()))'
                    ]
                )
            );
        $paladin->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('aura-of-justice', $power);

        $power = (new ClassPower())
            ->setName('Fourth Mercy (Su)')
            ->setLevel(12)
            ->setClass($paladin)
            ->setPassive(true);
        $paladin->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('mercy-4', $power);

        $power = (new ClassPower())
            ->setName('Aura of Faith (Su)')
            ->setLevel(14)
            ->setClass($paladin)
            ->setPassive(true);
        $paladin->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('aura-of-faith', $power);

        $power = (new ClassPower())
            ->setName('Fifth Mercy (Su)')
            ->setLevel(15)
            ->setClass($paladin)
            ->setPassive(true);
        $paladin->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('mercy-5', $power);

        $power = (new ClassPower())
            ->setName('Aura of Righteousness (Su)')
            ->setLevel(17)
            ->setClass($paladin)
            ->setPassive(true);
        $paladin->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('aura-of-righteousness', $power);

        $power = (new ClassPower())
            ->setName('Sixth Mercy (Su)')
            ->setLevel(18)
            ->setClass($paladin)
            ->setPassive(true);
        $paladin->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('mercy-6', $power);

        $power = (new ClassPower())
            ->setName('Holy Champion (Su)')
            ->setLevel(20)
            ->setClass($paladin)
            ->setPassive(false);
        $paladin->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('holy-champion', $power);

        $manager->persist($paladin);
        $manager->flush();
        $this->addReference('paladin', $paladin);

        $bab       = array(0, 1, 2, 3, 3, 4, 5, 6, 6, 7, 8, 9, 9, 10, 11, 12, 12, 13, 14, 15);
        $reflexes  = array();
        $fortitude = array();
        $will      = array();
        for ($i = 0; $i < 20; $i++) {
            $reflexes[]  = ((int)(($i + 1) / 2)) + 2;
            $fortitude[] = ((int)(($i + 1) / 3));
            $will[]      = (int)(($i + 1) / 2) + 2;
        }
        $spellsPerDay        = array(
            1 => array(1, 2, 3, 3, 4, 4, 4, 4, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5),
            2 => array(-1, -1, -1, 1, 2, 3, 3, 4, 4, 4, 4, 5, 5, 5, 5, 5, 5, 5, 5, 5),
            3 => array(-1, -1, -1, -1, -1, -1, 1, 2, 3, 3, 4, 4, 4, 4, 5, 5, 5, 5, 5, 5),
            4 => array(-1, -1, -1, -1, -1, -1, -1, -1, -1, 1, 2, 3, 3, 4, 4, 4, 4, 5, 5, 5),
            5 => array(-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 1, 2, 3, 3, 4, 4, 5, 5),
            6 => array(-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 1, 2, 3, 4, 5),
        );
        $knownSpellsPerLevel = array(
            0 => array(4, 5, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6),
            1 => array(2, 3, 4, 4, 4, 4, 5, 5, 5, 5, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6),
            2 => array(0, 0, 0, 2, 3, 4, 4, 4, 4, 5, 5, 5, 5, 6, 6, 6, 6, 6, 6, 6),
            3 => array(0, 0, 0, 0, 0, 0, 2, 3, 4, 4, 4, 4, 5, 5, 5, 5, 6, 6, 6, 6),
            4 => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 3, 4, 4, 4, 4, 5, 5, 5, 5, 6),
            5 => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 3, 4, 4, 4, 4, 5, 5),
            6 => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 3, 4, 4, 5)
        );


        $bard = new ClassDefinition();
        /** @noinspection PhpParamsInspection */
        $bard
            ->setName("Bard")
            ->setHpDice(8)
            ->setSkillPoints(6)
            ->setBab($bab)
            ->setReflexes($reflexes)
            ->setFortitude($fortitude)
            ->setWill($will)
            ->setSpellsPerDay($spellsPerDay)
            ->setCastingAbility('charisma')
            ->setPreparationNeeded(false)
            ->setKnownSpellsPerLevel($knownSpellsPerLevel)
            ->addClassSkill($this->getReference('acrobatics'))
            ->addClassSkill($this->getReference('appraise'))
            ->addClassSkill($this->getReference('bluff'))
            ->addClassSkill($this->getReference('climb'))
            ->addClassSkill($this->getReference('craft'))
            ->addClassSkill($this->getReference('diplomacy'))
            ->addClassSkill($this->getReference('disguise'))
            ->addClassSkill($this->getReference('escapeArtist'))
            ->addClassSkill($this->getReference('intimidate'))
            ->addClassSkill($this->getReference('knowledgeArcana'))
            ->addClassSkill($this->getReference('knowledgeDungeoneering'))
            ->addClassSkill($this->getReference('knowledgeEngineering'))
            ->addClassSkill($this->getReference('knowledgeGeography'))
            ->addClassSkill($this->getReference('knowledgeHistory'))
            ->addClassSkill($this->getReference('knowledgeLocal'))
            ->addClassSkill($this->getReference('knowledgeNature'))
            ->addClassSkill($this->getReference('knowledgeNobility'))
            ->addClassSkill($this->getReference('knowledgePlanes'))
            ->addClassSkill($this->getReference('knowledgeReligion'))
            ->addClassSkill($this->getReference('linguistics'))
            ->addClassSkill($this->getReference('perception'))
            ->addClassSkill($this->getReference('perform'))
            ->addClassSkill($this->getReference('profession'))
            ->addClassSkill($this->getReference('senseMotive'))
            ->addClassSkill($this->getReference('sleightOfHand'))
            ->addClassSkill($this->getReference('spellcraft'))
            ->addClassSkill($this->getReference('stealth'))
            ->addClassSkill($this->getReference('useMagicDevice'));

        $power = (new ClassPower())
            ->setName('Bardic Knowledge (Ex)')
            ->setLevel(1)
            ->setClass($bard)
            ->setPassive(true)
            ->setEffects(
                array(
                    'knowledge-arcana'        => ['type' => 'class', 'value' => 'max(1, div(c.getLevel(4), 2))'],
                    'knowledge-dungeoneering' => ['type' => 'class', 'value' => 'max(1, div(c.getLevel(4), 2))'],
                    'knowledge-engineering' => ['type' => 'class', 'value' => 'max(1, div(c.getLevel(4), 2))'],
                    'knowledge-geography'     => ['type' => 'class', 'value' => 'max(1, div(c.getLevel(4), 2))'],
                    'knowledge-history'       => ['type' => 'class', 'value' => 'max(1, div(c.getLevel(4), 2))'],
                    'knowledge-local'         => ['type' => 'class', 'value' => 'max(1, div(c.getLevel(4), 2))'],
                    'knowledge-nature'        => ['type' => 'class', 'value' => 'max(1, div(c.getLevel(4), 2))'],
                    'knowledge-nobility'      => ['type' => 'class', 'value' => 'max(1, div(c.getLevel(4), 2))'],
                    'knowledge-planes'        => ['type' => 'class', 'value' => 'max(1, div(c.getLevel(4), 2))'],
                    'knowledge-religion'      => ['type' => 'class', 'value' => 'max(1, div(c.getLevel(4), 2))']
                )
            );
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('bardic-knowledge', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Countersong')
            ->setLevel(1)
            ->setClass($bard)
            ->setPassive(false)
            ->setCastable(true);
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('bardic-performance-countersong', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Distraction')
            ->setLevel(1)
            ->setClass($bard)
            ->setPassive(false)
            ->setCastable(true);
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('bardic-performance-distraction', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Fascinate')
            ->setLevel(1)
            ->setClass($bard)
            ->setPassive(false)
            ->setCastable(true);
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('bardic-performance - Fascinate', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Inspire Courage')
            ->setLevel(1)
            ->setClass($bard)
            ->setPassive(true)
            ->setCastable(true)
            ->setEffects(
                array(
                    'melee-attack-roll'  => [
                        'type'  => 'competence',
                        'value' => '1 + (level >= 17 ? 3 : (level >= 11 ? 2 : (level >= 5 ? 1)))'
                    ],
                    'ranged-attack-roll' => [
                        'type'  => 'competence',
                        'value' => '1 + (level >= 17 ? 3 : (level >= 11 ? 2 : (level >= 5 ? 1)))'
                    ],
                    'melee-damage-roll'  => [
                        'type'  => 'competence',
                        'value' => '1 + (level >= 17 ? 3 : (level >= 11 ? 2 : (level >= 5 ? 1)))'
                    ],
                    'ranged-damage-roll' => [
                        'type'  => 'competence',
                        'value' => '1 + (level >= 17 ? 3 : (level >= 11 ? 2 : (level >= 5 ? 1)))'
                    ],
                    'saving-charm'       => [
                        'type'  => 'morale',
                        'value' => '1 + (level >= 17 ? 3 : (level >= 11 ? 2 : (level >= 5 ? 1)))'
                    ],
                    'saving-fear'        => [
                        'type'  => 'competence',
                        'value' => '1 + (level >= 17 ? 3 : (level >= 11 ? 2 : (level >= 5 ? 1)))'
                    ],
                )
            );
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('bardic-performance-inspire-courage', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Inspire Competence')
            ->setLevel(3)
            ->setClass($bard)
            ->setPassive(true)
            ->setCastable(true)
            ->setEffects(
                array(
                    'skills' => ['type' => 'competence', 'value' => '2 + div(level - 3, 4)']
                )
            );
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('bardic-performance-inspire-competence', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Suggestion')
            ->setLevel(6)
            ->setClass($bard)
            ->setPassive(false)
            ->setCastable(true);
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('bardic-performance-suggestion', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Dirge of Doom')
            ->setLevel(8)
            ->setClass($bard)
            ->setPassive(false)
            ->setCastable(true);
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('bardic-performance-dirge-of-doom', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Inspire Greatness')
            ->setLevel(9)
            ->setClass($bard)
            ->setPassive(false)
            ->setCastable(true);
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('bardic-performance-inspire-greatness', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Soothing Performance')
            ->setLevel(12)
            ->setClass($bard)
            ->setPassive(false)
            ->setCastable(true);
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('bardic-performance-soothing-performance', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Frightening Tune')
            ->setLevel(14)
            ->setClass($bard)
            ->setPassive(false)
            ->setCastable(true);
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('bardic-performance-frightening-tune', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Inspire Heroics')
            ->setLevel(15)
            ->setClass($bard)
            ->setPassive(false)
            ->setCastable(true);
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('bardic-performance-inspire-heroics', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Mass Suggestion')
            ->setLevel(18)
            ->setClass($bard)
            ->setPassive(false)
            ->setCastable(true);
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('bardic-performance-mass-suggestion', $power);

        $power = (new ClassPower())
            ->setName('Bardic Performance - Deadly Performance')
            ->setLevel(20)
            ->setClass($bard)
            ->setPassive(false)
            ->setCastable(true);
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('bardic-performance-deadly-performance', $power);

        $power = (new ClassPower())
            ->setName('First Versatile Performance (Ex)')
            ->setLevel(2)
            ->setClass($bard)
            ->setPassive(true)
        ;
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('versatile-performance-1', $power);

        $power = (new ClassPower())
            ->setName('Second Versatile Performance (Ex)')
            ->setLevel(6)
            ->setClass($bard)
            ->setPassive(true);
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('versatile-performance-2', $power);

        $power = (new ClassPower())
            ->setName('Third Versatile Performance (Ex)')
            ->setLevel(10)
            ->setClass($bard)
            ->setPassive(true);
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('versatile-performance-3', $power);

        $power = (new ClassPower())
            ->setName('Fourth Versatile Performance (Ex)')
            ->setLevel(14)
            ->setClass($bard)
            ->setPassive(true);
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('versatile-performance-4', $power);

        $power = (new ClassPower())
            ->setName('Fifth Versatile Performance (Ex)')
            ->setLevel(18)
            ->setClass($bard)
            ->setPassive(true);
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('versatile-performance-5', $power);

        /** @noinspection PhpParamsInspection */
        $power = (new ClassPower())
            ->setName('Versatile Performance - Act')
            ->addParent($this->getReference('versatile-performance-1'))
            ->addParent($this->getReference('versatile-performance-2'))
            ->addParent($this->getReference('versatile-performance-3'))
            ->addParent($this->getReference('versatile-performance-4'))
            ->addParent($this->getReference('versatile-performance-5'))
            ->setPassive(true)
            ->setEffects(
                array(
                    'bluff'      => [
                        'type'  => 'class',
                        'value' => "c.getSkillValue(skill('perform')) - c.getSkillValue(skill('bluff'))"
                    ],
                    'disguise' => [
                        'type'  => 'class',
                        'value' => "c.getSkillValue(skill('perform')) - c.getSkillValue(skill('disguise'))"
                    ],
                )
            );
        $this->addReference('versatile-performance-act', $power);

        /** @noinspection PhpParamsInspection */
        $power = (new ClassPower())
            ->setName('Versatile Performance - Comedy')
            ->addParent($this->getReference('versatile-performance-1'))
            ->addParent($this->getReference('versatile-performance-2'))
            ->addParent($this->getReference('versatile-performance-3'))
            ->addParent($this->getReference('versatile-performance-4'))
            ->addParent($this->getReference('versatile-performance-5'))
            ->setPassive(true)
            ->setEffects(
                array(
                    'bluff'    => [
                        'type'  => 'class',
                        'value' => "c.getSkillValue(skill('perform')) - c.getSkillValue(skill('bluff'))"
                    ],
                    'intimidate' => ['type'  => 'class',
                                   'value' => "c.getSkillValue(skill('perform')) - c.getSkillValue(skill('intimidate'))"
                    ],
                )
            );
        $this->addReference('versatile-performance-comedy', $power);

        /** @noinspection PhpParamsInspection */
        $power = (new ClassPower())
            ->setName('Versatile Performance - Dance')
            ->addParent($this->getReference('versatile-performance-1'))
            ->addParent($this->getReference('versatile-performance-2'))
            ->addParent($this->getReference('versatile-performance-3'))
            ->addParent($this->getReference('versatile-performance-4'))
            ->addParent($this->getReference('versatile-performance-5'))
            ->setPassive(true)
            ->setEffects(
                array(
                    'acrobatics'    => [
                        'type'  => 'class',
                        'value' => "c.getSkillValue(skill('perform')) - c.getSkillValue(skill('acrobatics'))"
                    ],
                    'fly' => ['type'  => 'class',
                                   'value' => "c.getSkillValue(skill('perform')) - c.getSkillValue(skill('fly'))"
                    ],
                )
            );
        $this->addReference('versatile-performance-dance', $power);

        /** @noinspection PhpParamsInspection */
        $power = (new ClassPower())
            ->setName('Versatile Performance - Keyboard Instruments')
            ->addParent($this->getReference('versatile-performance-1'))
            ->addParent($this->getReference('versatile-performance-2'))
            ->addParent($this->getReference('versatile-performance-3'))
            ->addParent($this->getReference('versatile-performance-4'))
            ->addParent($this->getReference('versatile-performance-5'))
            ->setPassive(true)
            ->setEffects(
                array(
                    'diplomacy'    => [
                        'type'  => 'class',
                        'value' => "c.getSkillValue(skill('perform')) - c.getSkillValue(skill('diplomacy'))"
                    ],
                    'intimidate' => ['type'  => 'class',
                                   'value' => "c.getSkillValue(skill('perform')) - c.getSkillValue(skill('intimidate'))"
                    ],
                )
            );
        $this->addReference('versatile-performance-keyboard-instruments', $power);

        /** @noinspection PhpParamsInspection */
        $power = (new ClassPower())
            ->setName('Versatile Performance - Oratory')
            ->addParent($this->getReference('versatile-performance-1'))
            ->addParent($this->getReference('versatile-performance-2'))
            ->addParent($this->getReference('versatile-performance-3'))
            ->addParent($this->getReference('versatile-performance-4'))
            ->addParent($this->getReference('versatile-performance-5'))
            ->setPassive(true)
            ->setEffects(
                array(
                    'diplomacy'    => [
                        'type'  => 'class',
                        'value' => "c.getSkillValue(skill('perform')) - c.getSkillValue(skill('diplomacy'))"
                    ],
                    'sense-motive' => ['type'  => 'class',
                                   'value' => "c.getSkillValue(skill('perform')) - c.getSkillValue(skill('sense-motive'))"
                    ],
                )
            );
        $this->addReference('versatile-performance-oratory', $power);

        /** @noinspection PhpParamsInspection */
        $power = (new ClassPower())
            ->setName('Versatile Performance - Percussion Instruments')
            ->addParent($this->getReference('versatile-performance-1'))
            ->addParent($this->getReference('versatile-performance-2'))
            ->addParent($this->getReference('versatile-performance-3'))
            ->addParent($this->getReference('versatile-performance-4'))
            ->addParent($this->getReference('versatile-performance-5'))
            ->setPassive(true)
            ->setEffects(
                array(
                    'handle-animal'    => [
                        'type'  => 'class',
                        'value' => "c.getSkillValue(skill('perform')) - c.getSkillValue(skill('handle-animal'))"
                    ],
                    'intimidate' => ['type'  => 'class',
                                   'value' => "c.getSkillValue(skill('perform')) - c.getSkillValue(skill('intimidate'))"
                    ],
                )
            );
        $this->addReference('versatile-performance-percussion', $power);

        /** @noinspection PhpParamsInspection */
        $power = (new ClassPower())
            ->setName('Versatile Performance - Sing')
            ->addParent($this->getReference('versatile-performance-1'))
            ->addParent($this->getReference('versatile-performance-2'))
            ->addParent($this->getReference('versatile-performance-3'))
            ->addParent($this->getReference('versatile-performance-4'))
            ->addParent($this->getReference('versatile-performance-5'))
            ->setPassive(true)
            ->setEffects(
                array(
                    'bluff'    => [
                        'type'  => 'class',
                        'value' => "c.getSkillValue(skill('perform')) - c.getSkillValue(skill('bluff'))"
                    ],
                    'sense-motive' => ['type'  => 'class',
                                   'value' => "c.getSkillValue(skill('perform')) - c.getSkillValue(skill('sense-motive'))"
                    ],
                )
            );
        $this->addReference('versatile-performance-sing', $power);

        /** @noinspection PhpParamsInspection */
        $power = (new ClassPower())
            ->setName('Versatile Performance - String Instruments')
            ->addParent($this->getReference('versatile-performance-1'))
            ->addParent($this->getReference('versatile-performance-2'))
            ->addParent($this->getReference('versatile-performance-3'))
            ->addParent($this->getReference('versatile-performance-4'))
            ->addParent($this->getReference('versatile-performance-5'))
            ->setPassive(true)
            ->setEffects(
                array(
                    'bluff'    => [
                        'type'  => 'class',
                        'value' => "c.getSkillValue(skill('perform')) - c.getSkillValue(skill('bluff'))"
                    ],
                    'diplomacy' => ['type'  => 'class',
                                   'value' => "c.getSkillValue(skill('perform')) - c.getSkillValue(skill('diplomacy'))"
                    ],
                )
            );
        $this->addReference('versatile-performance-string', $power);

        /** @noinspection PhpParamsInspection */
        $power = (new ClassPower())
            ->setName('Versatile Performance - Wind Instruments')
            ->addParent($this->getReference('versatile-performance-1'))
            ->addParent($this->getReference('versatile-performance-2'))
            ->addParent($this->getReference('versatile-performance-3'))
            ->addParent($this->getReference('versatile-performance-4'))
            ->addParent($this->getReference('versatile-performance-5'))
            ->setPassive(true)
            ->setEffects(
                array(
                    'diplomacy'    => [
                        'type'  => 'class',
                        'value' => "c.getSkillValue(skill('perform')) - c.getSkillValue(skill('diplomacy'))"
                    ],
                    'handle-animal' => ['type'  => 'class',
                                   'value' => "c.getSkillValue(skill('perform')) - c.getSkillValue(skill('handle-animal'))"
                    ],
                )
            );
        $this->addReference('versatile-performance-wind', $power);

        $power = (new ClassPower())
            ->setName('Well Versed (Ex)')
            ->setPassive(true)
            ->setEffects(
                array(
                    'saving-bardic'   => ['type' => 'class', 'value' => 4],
                    'saving-sonic'    => ['type' => 'class', 'value' => 4],
                    'saving-language' => ['type' => 'class', 'value' => 4],
                )
            );
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('well-versed', $power);

        $power = (new ClassPower())
            ->setName('Lore Master (Ex)')
            ->setLevel(5)
            ->setClass($bard)
            ->setPassive(false)
        ;
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('lore-master', $power);

        $power = (new ClassPower())
            ->setName('Jack of All Trades (Ex)')
            ->setLevel(10)
            ->setClass($bard)
            ->setPassive(true)
            ->setEffects(
                array(
                    'disable-device' => [
                        'type'  => null,
                        'value' => "(c.getLevel(4) >= 16 && c.getSkillRank(skill('disable-device'))) > 0 ? 3 : 0"
                    ],
                    'fly'            => [
                        'type' => null,
                        'value' => "(c.getLevel(4) >= 16 && c.getSkillRank(skill('fly'))) > 0 ? 3 : 0"
                    ],
                    'handle-animal'  => [
                        'type' => null,
                        'value' => "(c.getLevel(4) >= 16 && c.getSkillRank(skill('handle-animal'))) > 0 ? 3 : 0"
                    ],
                    'heal'           => [
                        'type' => null,
                        'value' => "(c.getLevel(4) >= 16 && c.getSkillRank(skill('heal'))) > 0 ? 3 : 0"
                    ],
                    'ride'           => [
                        'type' => null,
                        'value' => "(c.getLevel(4) >= 16 && c.getSkillRank(skill('ride'))) > 0 ? 3 : 0"
                    ],
                    'survival'       => [
                        'type' => null,
                        'value' => "(c.getLevel(4) >= 16 && c.getSkillRank(skill('survival'))) > 0 ? 3 : 0"
                    ],
                    'swim'           => [
                        'type' => null,
                        'value' => "(c.getLevel(4) >= 16 && c.getSkillRank(skill('swim'))) > 0 ? 3 : 0"
                    ]
                )
            )
        ;
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }
        $this->addReference('jack-of-all-trades', $power);

        $manager->persist($bard);
        $manager->flush();

        $this->addReference('bard', $bard);

        $bab = array(0, 1, 2, 3, 3, 4, 5, 6, 6, 7, 8, 9, 9, 10, 11, 12, 12, 13, 14, 15);
        $reflexes  = array();
        $fortitude = array();
        $will      = array();
        for ($i = 0; $i < 20; $i++) {
            $fortitude[] = ((int)(($i + 1) / 2)) + 2;
            $reflexes[] = (int)(($i + 1) / 3);
            $will[]      = ((int)(($i + 1) / 2)) + 2;
        }
        $spellsPerDay = array(
            0 => array(3, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4),
            1 => array(1, 2, 2, 3, 3, 3, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4),
            2 => array(-1, -1, 1, 2, 2, 3, 3, 3, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4),
            3 => array(-1, -1, -1, -1, 1, 2, 2, 3, 3, 3, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4),
            4 => array(-1, -1, -1, -1, -1, -1, 1, 2, 2, 3, 3, 3, 4, 4, 4, 4, 4, 4, 4, 4),
            5 => array(-1, -1, -1, -1, -1, -1, -1, -1, 1, 2, 2, 3, 3, 3, 4, 4, 4, 4, 4, 4),
            6 => array(-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 1, 2, 2, 3, 3, 3, 4, 4, 4, 4),
            7 => array(-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 1, 2, 2, 3, 3, 3, 4, 4),
            8 => array(-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 1, 2, 2, 3, 3, 4),
            9 => array(-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 1, 2, 3, 4)
        );

        $cleric = new ClassDefinition();
        /** @noinspection PhpParamsInspection */
        $cleric
            ->setName("Cleric")
            ->setHpDice(8)
            ->setSkillPoints(2)
            ->setBab($bab)
            ->setReflexes($reflexes)
            ->setFortitude($fortitude)
            ->setWill($will)
            ->setSpellsPerDay($spellsPerDay)
            ->setCastingAbility('wisdom')
            ->setPreparationNeeded(true)
            ->addClassSkill($this->getReference('appraise'))
            ->addClassSkill($this->getReference('craft'))
            ->addClassSkill($this->getReference('diplomacy'))
            ->addClassSkill($this->getReference('heal'))
            ->addClassSkill($this->getReference('knowledgeArcana'))
            ->addClassSkill($this->getReference('knowledgeHistory'))
            ->addClassSkill($this->getReference('knowledgeNobility'))
            ->addClassSkill($this->getReference('knowledgePlanes'))
            ->addClassSkill($this->getReference('knowledgeReligion'))
            ->addClassSkill($this->getReference('linguistics'))
            ->addClassSkill($this->getReference('profession'))
            ->addClassSkill($this->getReference('senseMotive'))
            ->addClassSkill($this->getReference('spellcraft'));

        $power = (new ClassPower())
            ->setName('Channel Energy (Su)')
            ->setLevel(1)
            ->setClass($cleric)
            ->setPassive(true)
            ->setCastable(true);
        $bard->addPower($power);
        if (array_key_exists($power->getName(), $powers)) {
            $translationsRepository->translate($power, 'name', 'fr', $powers[$power->getName()]['name_fr']);
        }

        $manager->persist($cleric);
        $manager->flush();

        $this->addReference('cleric', $cleric);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 7;
    }
}
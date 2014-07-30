<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troulite\PathfinderBundle\Entity\ClassSpell;

/**
 * Class LoadClassSpellData
 *
 * @package Troulite\PathfinderBundle\DataFixtures\ORM
 */
class LoadClassSpellData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-find-the-path'))->setClass($this->getReference('bard'))->setSpellLevel(6);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-freedom-of-movement'))->setClass($this->getReference('bard'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-freedom-of-movement'))->setClass($this->getReference('ranger'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-gaseous-form'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-haste'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-holy-sword'))->setClass($this->getReference('paladin'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-illusory-script'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-legend-lore'))->setClass($this->getReference('bard'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-light'))->setClass($this->getReference('bard'))->setSpellLevel(0);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-longstrider'))->setClass($this->getReference('ranger'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-alarm'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-alarm'))->setClass($this->getReference('ranger'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-alter-self'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-analyze-dweomer'))->setClass($this->getReference('bard'))->setSpellLevel(6);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-animal-growth'))->setClass($this->getReference('ranger'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-animal-messenger'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-animal-messenger'))->setClass($this->getReference('ranger'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-animal-trance'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-animate-objects'))->setClass($this->getReference('bard'))->setSpellLevel(6);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-animate-rope'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-barkskin'))->setClass($this->getReference('ranger'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-bears-endurance'))->setClass($this->getReference('ranger'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-bless'))->setClass($this->getReference('paladin'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-bless-water'))->setClass($this->getReference('paladin'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-bless-weapon'))->setClass($this->getReference('paladin'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-blindness-deafness'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-blink'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-blur'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-break-enchantment'))->setClass($this->getReference('bard'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-break-enchantment'))->setClass($this->getReference('paladin'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-bulls-strength'))->setClass($this->getReference('paladin'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-calm-animals'))->setClass($this->getReference('ranger'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-cats-grace'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-cats-grace'))->setClass($this->getReference('ranger'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-cats-grace-mass'))->setClass($this->getReference('bard'))->setSpellLevel(6);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-cause-fear'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-charm-animal'))->setClass($this->getReference('ranger'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-charm-monster'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-charm-person'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-clairaudience-clairvoyance'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-command-plants'))->setClass($this->getReference('ranger'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-commune-with-nature'))->setClass($this->getReference('ranger'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-comprehend-languages'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-confusion-lesser'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-create-water'))->setClass($this->getReference('paladin'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-crushing-despair'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-cure-critical-wounds'))->setClass($this->getReference('bard'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-cure-light-wounds'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-cure-light-wounds'))->setClass($this->getReference('paladin'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-cure-light-wounds'))->setClass($this->getReference('ranger'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-cure-moderate-wounds'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-cure-moderate-wounds'))->setClass($this->getReference('paladin'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-cure-moderate-wounds'))->setClass($this->getReference('ranger'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-cure-serious-wounds'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-cure-serious-wounds'))->setClass($this->getReference('paladin'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-cure-serious-wounds'))->setClass($this->getReference('ranger'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-dancing-lights'))->setClass($this->getReference('bard'))->setSpellLevel(0);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-darkness'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-darkvision'))->setClass($this->getReference('ranger'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-daylight'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-daylight'))->setClass($this->getReference('paladin'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-daze'))->setClass($this->getReference('bard'))->setSpellLevel(0);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-daze-monster'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-death-ward'))->setClass($this->getReference('paladin'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-deep-slumber'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-delay-poison'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-delay-poison'))->setClass($this->getReference('paladin'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-delay-poison'))->setClass($this->getReference('ranger'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-detect-animals-or-plants'))->setClass($this->getReference('ranger'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-detect-poison'))->setClass($this->getReference('paladin'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-detect-poison'))->setClass($this->getReference('ranger'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-detect-secret-doors'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-detect-thoughts'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-dimension-door'))->setClass($this->getReference('bard'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-diminish-plants'))->setClass($this->getReference('ranger'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-discern-lies'))->setClass($this->getReference('paladin'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-disguise-self'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-dispel-chaos'))->setClass($this->getReference('paladin'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-dispel-evil'))->setClass($this->getReference('paladin'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-divine-favor'))->setClass($this->getReference('paladin'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-dominate-person'))->setClass($this->getReference('bard'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-eagles-splendor'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-eagles-splendor'))->setClass($this->getReference('paladin'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-eagles-splendor-mass'))->setClass($this->getReference('bard'))->setSpellLevel(6);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-endure-elements'))->setClass($this->getReference('paladin'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-endure-elements'))->setClass($this->getReference('ranger'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-entangle'))->setClass($this->getReference('ranger'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-enthrall'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-false-vision'))->setClass($this->getReference('bard'))->setSpellLevel(5);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-fear'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-feather-fall'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-flare'))->setClass($this->getReference('bard'))->setSpellLevel(0);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-foxs-cunning'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-foxs-cunning-mass'))->setClass($this->getReference('bard'))->setSpellLevel(6);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-geas-lesser'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-geas-quest'))->setClass($this->getReference('bard'))->setSpellLevel(6);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-ghost-sound'))->setClass($this->getReference('bard'))->setSpellLevel(0);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-glibness'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-glitterdust'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-good-hope'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-grease'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-hallucinatory-terrain'))->setClass($this->getReference('bard'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-heal-mount'))->setClass($this->getReference('paladin'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-heroes-feast'))->setClass($this->getReference('bard'))->setSpellLevel(6);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-heroism'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-heroism-greater'))->setClass($this->getReference('bard'))->setSpellLevel(5);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-hide-from-animals'))->setClass($this->getReference('ranger'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-hideous-laughter'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-hold-animal'))->setClass($this->getReference('ranger'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-hold-monster'))->setClass($this->getReference('bard'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-hold-person'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-hypnotic-pattern'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-hypnotism'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-identify'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-invisibility'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-invisibility-greater'))->setClass($this->getReference('bard'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-irresistible-dance'))->setClass($this->getReference('bard'))->setSpellLevel(6);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-jump'))->setClass($this->getReference('ranger'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-know-direction'))->setClass($this->getReference('bard'))->setSpellLevel(0);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-locate-creature'))->setClass($this->getReference('bard'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-locate-object'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-lullaby'))->setClass($this->getReference('bard'))->setSpellLevel(0);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-mage-hand'))->setClass($this->getReference('bard'))->setSpellLevel(0);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-magic-circle-against-chaos'))->setClass($this->getReference('paladin'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-magic-fang'))->setClass($this->getReference('ranger'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-magic-weapon'))->setClass($this->getReference('paladin'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-magic-weapon-greater'))->setClass($this->getReference('paladin'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-major-image'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-mark-of-justice'))->setClass($this->getReference('paladin'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-mending'))->setClass($this->getReference('bard'))->setSpellLevel(0);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-message'))->setClass($this->getReference('bard'))->setSpellLevel(0);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-mind-fog'))->setClass($this->getReference('bard'))->setSpellLevel(5);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-minor-image'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-mirage-arcana'))->setClass($this->getReference('bard'))->setSpellLevel(5);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-mirror-image'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-neutralize-poison'))->setClass($this->getReference('bard'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-neutralize-poison'))->setClass($this->getReference('paladin'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-neutralize-poison'))->setClass($this->getReference('ranger'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-nondetection'))->setClass($this->getReference('ranger'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-obscure-object'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-open-close'))->setClass($this->getReference('bard'))->setSpellLevel(0);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-owls-wisdom'))->setClass($this->getReference('paladin'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-owls-wisdom'))->setClass($this->getReference('ranger'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-pass-without-trace'))->setClass($this->getReference('ranger'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-permanent-image'))->setClass($this->getReference('bard'))->setSpellLevel(6);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-plant-growth'))->setClass($this->getReference('ranger'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-prayer'))->setClass($this->getReference('paladin'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-prestidigitation'))->setClass($this->getReference('bard'))->setSpellLevel(0);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-programmed-image'))->setClass($this->getReference('bard'))->setSpellLevel(6);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-project-image'))->setClass($this->getReference('bard'))->setSpellLevel(6);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-protection-from-chaos'))->setClass($this->getReference('paladin'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-protection-from-energy'))->setClass($this->getReference('ranger'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-protection-from-evil'))->setClass($this->getReference('paladin'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-pyrotechnics'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-rage'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-rainbow-pattern'))->setClass($this->getReference('bard'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-reduce-animal'))->setClass($this->getReference('ranger'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-remove-curse'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-remove-curse'))->setClass($this->getReference('paladin'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-remove-disease'))->setClass($this->getReference('ranger'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-remove-fear'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-remove-paralysis'))->setClass($this->getReference('paladin'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-repel-vermin'))->setClass($this->getReference('bard'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-repel-vermin'))->setClass($this->getReference('ranger'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-resist-energy'))->setClass($this->getReference('paladin'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-resist-energy'))->setClass($this->getReference('ranger'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-resistance'))->setClass($this->getReference('bard'))->setSpellLevel(0);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-resistance'))->setClass($this->getReference('paladin'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-restoration'))->setClass($this->getReference('paladin'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-scare'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-sculpt-sound'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-secret-page'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-secure-shelter'))->setClass($this->getReference('bard'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-seeming'))->setClass($this->getReference('bard'))->setSpellLevel(5);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-sepia-snake-sigil'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-shadow-conjuration'))->setClass($this->getReference('bard'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-shadow-evocation'))->setClass($this->getReference('bard'))->setSpellLevel(5);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-shadow-walk'))->setClass($this->getReference('bard'))->setSpellLevel(5);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-shatter'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-shield-other'))->setClass($this->getReference('paladin'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-shout'))->setClass($this->getReference('bard'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-shout-greater'))->setClass($this->getReference('bard'))->setSpellLevel(6);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-silence'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-silent-image'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-sleep'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-slow'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-snare'))->setClass($this->getReference('ranger'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-song-of-discord'))->setClass($this->getReference('bard'))->setSpellLevel(5);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-sound-burst'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-speak-with-animals'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-speak-with-animals'))->setClass($this->getReference('ranger'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-speak-with-plants'))->setClass($this->getReference('bard'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-speak-with-plants'))->setClass($this->getReference('ranger'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-suggestion'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-suggestion-mass'))->setClass($this->getReference('bard'))->setSpellLevel(5);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-summon-instrument'))->setClass($this->getReference('bard'))->setSpellLevel(0);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-summon-swarm'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-sympathetic-vibration'))->setClass($this->getReference('bard'))->setSpellLevel(6);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-tiny-hut'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-tongues'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-tree-shape'))->setClass($this->getReference('ranger'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-unseen-servant'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-ventriloquism'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-virtue'))->setClass($this->getReference('paladin'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-water-walk'))->setClass($this->getReference('ranger'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-whispering-wind'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-zone-of-truth'))->setClass($this->getReference('paladin'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-misdirection'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-magic-aura'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-magic-fang-greater'))->setClass($this->getReference('ranger'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-magic-mouth'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-modify-memory'))->setClass($this->getReference('bard'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-persistent-image'))->setClass($this->getReference('bard'))->setSpellLevel(5);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-phantom-steed'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-remove-blindness-deafness'))->setClass($this->getReference('paladin'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-restoration-lesser'))->setClass($this->getReference('paladin'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-scrying-greater'))->setClass($this->getReference('bard'))->setSpellLevel(6);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-see-invisibility'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-spike-growth'))->setClass($this->getReference('ranger'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-undetectable-alignment'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-undetectable-alignment'))->setClass($this->getReference('paladin'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-veil'))->setClass($this->getReference('bard'))->setSpellLevel(6);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-wind-wall'))->setClass($this->getReference('ranger'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-zone-of-silence'))->setClass($this->getReference('bard'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-confusion'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-detect-magic'))->setClass($this->getReference('bard'))->setSpellLevel(0);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-eyebite'))->setClass($this->getReference('bard'))->setSpellLevel(6);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-detect-undead'))->setClass($this->getReference('paladin'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-nightmare'))->setClass($this->getReference('bard'))->setSpellLevel(5);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-scrying'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-summon-natures-ally-4'))->setClass($this->getReference('ranger'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-summon-natures-ally-3'))->setClass($this->getReference('ranger'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-summon-natures-ally-2'))->setClass($this->getReference('ranger'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-summon-natures-ally-1'))->setClass($this->getReference('ranger'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-summon-monster-6'))->setClass($this->getReference('bard'))->setSpellLevel(6);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-summon-monster-5'))->setClass($this->getReference('bard'))->setSpellLevel(5);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-summon-monster-4'))->setClass($this->getReference('bard'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-summon-monster-3'))->setClass($this->getReference('bard'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-summon-monster-2'))->setClass($this->getReference('bard'))->setSpellLevel(2);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-summon-monster-1'))->setClass($this->getReference('bard'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-tree-stride'))->setClass($this->getReference('ranger'))->setSpellLevel(4);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-magic-circle-against-evil'))->setClass($this->getReference('paladin'))->setSpellLevel(3);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-read-magic'))->setClass($this->getReference('bard'))->setSpellLevel(0);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-read-magic'))->setClass($this->getReference('paladin'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-read-magic'))->setClass($this->getReference('ranger'))->setSpellLevel(1);
        $manager->persist($classSpell);

        $classSpell = (new ClassSpell())->setSpell($this->getReference('spell-mislead'))->setClass($this->getReference('bard'))->setSpellLevel(5);
        $manager->persist($classSpell);


        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 3;
    }
}
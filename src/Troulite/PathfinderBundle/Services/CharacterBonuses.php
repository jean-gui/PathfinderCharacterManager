<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 06/07/14
 * Time: 16:53
 */

namespace Troulite\PathfinderBundle\Services;

use Troulite\PathfinderBundle\Entity\Feat;
use Troulite\PathfinderBundle\Entity\Item;
use Troulite\PathfinderBundle\ExpressionLanguage\ExpressionLanguage;
use Troulite\PathfinderBundle\Model\Character;

/**
 * Class CharacterBonuses
 *
 * @package Troulite\PathfinderBundle\Services
 */
class CharacterBonuses
{
    /**
     * @var ExpressionLanguage
     */
    private $expressionLanguage;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->expressionLanguage = new ExpressionLanguage();
    }

    /**
     * @param Character $character
     *
     * @return Character
     */
    public function applyAll(Character $character)
    {
        $this->applyFeats($character);
        $this->applyItem($character, $character->getBaseCharacter()->getEquipment()->getMainWeapon());
        $this->applyItem($character, $character->getBaseCharacter()->getEquipment()->getOffhandWeapon());
        $this->applyItem($character, $character->getBaseCharacter()->getEquipment()->getBody());
        $this->applyItem($character, $character->getBaseCharacter()->getEquipment()->getHead());
        $this->applyItem($character, $character->getBaseCharacter()->getEquipment()->getHands());
        $this->applyItem($character, $character->getBaseCharacter()->getEquipment()->getLeftFinger());
        $this->applyItem($character, $character->getBaseCharacter()->getEquipment()->getRightFinger());
        $this->applyItem($character, $character->getBaseCharacter()->getEquipment()->getBelt());
        $this->applyItem($character, $character->getBaseCharacter()->getEquipment()->getFeet());
        $this->applyItem($character, $character->getBaseCharacter()->getEquipment()->getNeck());
        $this->applyItem($character, $character->getBaseCharacter()->getEquipment()->getBack());

        return $character;
    }

    /**
     * Apply all active feats to a character
     *
     * @param Character $character
     *
     * @return Character
     */
    public function applyFeats(Character $character)
    {
        foreach ($character->getBaseCharacter()->getFeats() as $feat) {
            if ($feat->isActive()) {
                $this->applyFeat($character, $feat->getFeat());
            }
        }

        return $character;
    }

    /**
     * Apply feat effects to a character
     *
     * @param Character $character
     * @param Feat $feat
     *
     * @return Character
     */
    public function applyFeat(Character $character, Feat $feat)
    {
        return $this->applyEffects($character, $feat->getEffect());
    }

    /**
     * Apply item effects to a character
     *
     * @param Character $character
     * @param Item|null $item
     *
     * @return Character
     */
    public function applyItem(Character $character, Item $item = null)
    {
        if ($item) {
            return $this->applyEffects($character, $item->getEffects());
        }

        return $character;
    }

    /**
     * Apply effects to a character
     *
     * @param Character $character
     * @param array $effects
     *
     * @return Character
     */
    private function applyEffects(Character $character, array $effects)
    {
        foreach ($effects as $stat => $effect) {
            $bonus = (int)$this->expressionLanguage->evaluate(
                $effect,
                array("c" => $character)
            );

            switch ($stat) {
                case 'strength':
                    $character->getBaseCharacter()->getAbilities()->setStrengthBonus(
                        $character->getBaseCharacter()->getAbilities()->getStrengthBonus() + $bonus);
                    break;
                case 'dexterity':
                    $character->getBaseCharacter()->getAbilities()->setDexterityBonus(
                        $character->getBaseCharacter()->getAbilities()->getDexterityBonus() + $bonus);
                    break;
                case 'constitution':
                    $character->getBaseCharacter()->getAbilities()->setConstitutionBonus(
                        $character->getBaseCharacter()->getAbilities()->getConstitutionBonus() + $bonus);
                    break;
                case 'intelligence':
                    $character->getBaseCharacter()->getAbilities()->setIntelligenceBonus(
                        $character->getBaseCharacter()->getAbilities()->getIntelligenceBonus() + $bonus);
                    break;
                case 'wisdom':
                    $character->getBaseCharacter()->getAbilities()->setWisdomBonus(
                        $character->getBaseCharacter()->getAbilities()->getWisdomBonus() + $bonus);
                    break;
                case 'charisma':
                    $character->getBaseCharacter()->getAbilities()->setCharismaBonus(
                        $character->getBaseCharacter()->getAbilities()->getCharismaBonus() + $bonus);
                    break;
                case 'fortitude':
                    $character->setFortitudeBonus($character->getFortitudeBonus() + $bonus);
                    break;
                case 'reflexes':
                    $character->setReflexesBonus($character->getReflexesBonus() + $bonus);
                    break;
                case 'will':
                    $character->setWillBonus($character->getWillBonus() + $bonus);
                    break;
                case 'initiative':
                    $character->setInitiativeBonus($character->getInitiativeBonus() + $bonus);
                    break;
                case 'ac':
                    $character->setAcBonus($character->getAcBonus() + $bonus);
                    break;
                case 'spell-resistance':
                    $character->setSpellResitanceBonus($character->getSpellResitanceBonus() + $bonus);
                    break;
                case 'cmb':
                    $character->setCmbBonus($character->getCmbBonus() + $bonus);
                    break;
                case 'cmd':
                    $character->setCmdBonus($character->getCmdBonus() + $bonus);
                    break;
                case 'melee-attack-roll':
                    $character->setMeleeAttackRollsBonus($character->getMeleeAttackRollsBonus() + $bonus);
                    break;
                case 'melee-damage-roll':
                    $character->setMeleeDamageBonus($character->getMeleeDamageBonus() + $bonus);
                    break;
                case 'melee-attacks':
                    $character->setMeleeAttacksBonus($character->getMeleeAttacksBonus() + $bonus);
                    break;
                case 'ranged-attack-roll':
                    $character->setRangedAttackRollsBonus($character->getRangedAttackRollsBonus() + $bonus);
                    break;
                case 'ranged-damage-roll':
                    $character->setRangedDamageBonus($character->getRangedDamageBonus() + $bonus);
                    break;
                case 'ranged-attacks':
                    $character->setRangedAttacksBonus($character->getRangedAttacksBonus() + $bonus);
                    break;
                case 'acrobatics':
                    $character->setSkillBonus('acrobatics', $character->getSkillBonus('acrobatics') + $bonus);

                    break;
                case 'appraise':
                    $character->setSkillBonus('appraise', $character->getSkillBonus('appraise') + $bonus);

                    break;
                case 'bluff':
                    $character->setSkillBonus('bluff', $character->getSkillBonus('bluff') + $bonus);

                    break;
                case 'climb':
                    $character->setSkillBonus('climb', $character->getSkillBonus('climb') + $bonus);

                    break;
                case 'craft':
                    $character->setSkillBonus('craft', $character->getSkillBonus('craft') + $bonus);

                    break;
                case 'diplomacy':
                    $character->setSkillBonus('diplomacy', $character->getSkillBonus('diplomacy') + $bonus);

                    break;
                case 'disable-device':
                    $character->setSkillBonus('disable-device', $character->getSkillBonus('disable-device') + $bonus);

                    break;
                case 'disguise':
                    $character->setSkillBonus('disguise', $character->getSkillBonus('disguise') + $bonus);

                    break;
                case 'escape-artist':
                    $character->setSkillBonus('escape-artist', $character->getSkillBonus('escape-artist') + $bonus);

                    break;
                case 'fly':
                    $character->setSkillBonus('fly', $character->getSkillBonus('fly') + $bonus);

                    break;
                case 'handle-animal':
                    $character->setSkillBonus('handle-animal', $character->getSkillBonus('handle-animal') + $bonus);

                    break;
                case 'heal':
                    $character->setSkillBonus('heal', $character->getSkillBonus('heal') + $bonus);

                    break;
                case 'intimidate':
                    $character->setSkillBonus('intimidate', $character->getSkillBonus('intimidate') + $bonus);

                    break;
                case 'knowledge-arcana':
                    $character->setSkillBonus(
                        'knowledge-arcana',
                        $character->getSkillBonus('knowledge-arcana') + $bonus
                    );

                    break;
                case 'knowledge-dungeoneering':
                    $character->setSkillBonus(
                        'knowledge-dungeoneering',
                        $character->getSkillBonus('knowledge-dungeoneering') + $bonus
                    );

                    break;
                case 'knowledge-geography':
                    $character->setSkillBonus(
                        'knowledge-geography',
                        $character->getSkillBonus('knowledge-geography') + $bonus
                    );

                    break;
                case 'knowledge-history':
                    $character->setSkillBonus(
                        'knowledge-history',
                        $character->getSkillBonus('knowledge-history') + $bonus
                    );

                    break;
                case 'knowledge-local':
                    $character->setSkillBonus('knowledge-local', $character->getSkillBonus('knowledge-local') + $bonus);

                    break;
                case 'knowledge-nature':
                    $character->setSkillBonus(
                        'knowledge-nature',
                        $character->getSkillBonus('knowledge-nature') + $bonus
                    );

                    break;
                case 'knwoledge-nobility':
                    $character->setSkillBonus(
                        'knwoledge-nobility',
                        $character->getSkillBonus('knwoledge-nobility') + $bonus
                    );

                    break;
                case 'knowledge-planes':
                    $character->setSkillBonus(
                        'knowledge-planes',
                        $character->getSkillBonus('knowledge-planes') + $bonus
                    );

                    break;
                case 'knowledge-religion':
                    $character->setSkillBonus(
                        'knowledge-religion',
                        $character->getSkillBonus('knowledge-religion') + $bonus
                    );

                    break;
                case 'linguistics':
                    $character->setSkillBonus('linguistics', $character->getSkillBonus('linguistics') + $bonus);

                    break;
                case 'perception':
                    $character->setSkillBonus('perception', $character->getSkillBonus('perception') + $bonus);

                    break;
                case 'perform':
                    $character->setSkillBonus('perform', $character->getSkillBonus('perform') + $bonus);

                    break;
                case 'profession':
                    $character->setSkillBonus('profession', $character->getSkillBonus('profession') + $bonus);

                    break;
                case 'ride':
                    $character->setSkillBonus('ride', $character->getSkillBonus('ride') + $bonus);

                    break;
                case 'sense-motive':
                    $character->setSkillBonus('sense-motive', $character->getSkillBonus('sense-motive') + $bonus);

                    break;
                case 'sleight-of-hand':
                    $character->setSkillBonus('sleight-of-hand', $character->getSkillBonus('sleight-of-hand') + $bonus);

                    break;
                case 'spellcraft':
                    $character->setSkillBonus('spellcraft', $character->getSkillBonus('spellcraft') + $bonus);

                    break;
                case 'stealth':
                    $character->setSkillBonus('stealth', $character->getSkillBonus('stealth') + $bonus);

                    break;
                case 'survival':
                    $character->setSkillBonus('survival', $character->getSkillBonus('survival') + $bonus);

                    break;
                case 'swim':
                    $character->setSkillBonus('swim', $character->getSkillBonus('swim') + $bonus);

                    break;
                case 'use-magic-device':
                    $character->setSkillBonus(
                        'use-magic-device',
                        $character->getSkillBonus('use-magic-device') + $bonus
                    );

                    break;
                case 'hp':
                    break;
                case 'speed':
                    break;
            }
        }

        return $character;
    }
} 
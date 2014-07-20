<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 06/07/14
 * Time: 16:53
 */

namespace Troulite\PathfinderBundle\Services;

use Troulite\PathfinderBundle\Entity\CharacterFeat;
use Troulite\PathfinderBundle\Entity\Feat;
use Troulite\PathfinderBundle\Entity\Item;
use Troulite\PathfinderBundle\Entity\Shield;
use Troulite\PathfinderBundle\ExpressionLanguage\ExpressionLanguage;
use Troulite\PathfinderBundle\Model\Bonus;
use Troulite\PathfinderBundle\Model\Bonuses;
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
        $this->applyRace($character);
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
     * Apply racial traits to a character
     * @param Character $character
     */
    private function applyRace(Character $character)
    {
        $this->applyEffects(
            $character,
            $character->getBaseCharacter()->getRace()->getTraits(),
            $character->getBaseCharacter()->getRace()
        );
    }

    /**
     * Apply all active feats to a character
     *
     * @param Character $character
     *
     * @return Character
     */
    private function applyFeats(Character $character)
    {
        foreach ($character->getFeats() as $feat) {
            if ($this->isApplicable($feat)) {
                $this->applyFeat($character, $feat->getFeat());
            }
        }

        return $character;
    }

    /**
     * Return whether a feat's bonuses can be applied
     *
     * @param CharacterFeat $characterFeat
     *
     * @return bool
     */
    private function isApplicable(CharacterFeat $characterFeat)
    {
        $character = $characterFeat->getCharacter();
        $feat = $characterFeat->getFeat();

        foreach ($feat->getConditions() as $type => $condition) {
            switch($type) {
                case 'weapon-type':
                    $weapon = $character->getEquipment()->getMainWeapon();
                    if (!$weapon || $weapon->getType() !== $condition) {
                        return false;
                    }
                    break;
                case 'equipped':
                    $mainHand = $character->getEquipment()->getMainWeapon();
                    $offHand  = $character->getEquipment()->getOffhandWeapon();
                    switch ($condition) {
                        case 'shield':
                            return $mainHand instanceof Shield or $offHand instanceof Shield;
                    }
            }
        }

        return ($feat->isPassive() && !$feat->hasExternalConditions()) || $characterFeat->isActive();
    }

    /**
     * Apply feat effects to a character
     *
     * @param Character $character
     * @param Feat $feat
     *
     * @return Character
     */
    private function applyFeat(Character $character, Feat $feat)
    {
        return $this->applyEffects($character, $feat->getEffect(), $feat);
    }

    /**
     * Apply item effects to a character
     *
     * @param Character $character
     * @param Item|null $item
     *
     * @return Character
     */
    private function applyItem(Character $character, Item $item = null)
    {
        if ($item) {
            return $this->applyEffects($character, $item->getEffects(), $item);
        }

        return $character;
    }

    /**
     * Apply effects to a character
     *
     * @param Character $character
     * @param array $effects
     * @param mixed $source
     *
     * @return Character
     *
     * @todo Handle bonus type
     */
    private function applyEffects(Character $character, array $effects, $source)
    {
        foreach ($effects as $stat => $effect) {
            $value = (int)$this->expressionLanguage->evaluate(
                $effect['value'],
                array("c" => $character)
            );
            $type = $effect['type'];
            $bonus = new Bonus($source, $value, $type);

            switch ($stat) {
                case 'strength':
                    $character->getBaseCharacter()->getAbilities()->getBonuses()->strength->add($bonus);
                    break;
                case 'dexterity':
                    $character->getBaseCharacter()->getAbilities()->getBonuses()->dexterity->add($bonus);
                    break;
                case 'constitution':
                    $character->getBaseCharacter()->getAbilities()->getBonuses()->constitution->add($bonus);
                    break;
                case 'intelligence':
                    $character->getBaseCharacter()->getAbilities()->getBonuses()->intelligence->add($bonus);
                    break;
                case 'wisdom':
                    $character->getBaseCharacter()->getAbilities()->getBonuses()->wisdom->add($bonus);
                    break;
                case 'charisma':
                    $character->getBaseCharacter()->getAbilities()->getBonuses()->charisma->add($bonus);
                    break;
                case 'fortitude':
                    $character->getDefenseBonuses()->fortitude->add($bonus);
                    break;
                case 'reflexes':
                    $character->getDefenseBonuses()->reflexes->add($bonus);
                    break;
                case 'will':
                    $character->getDefenseBonuses()->will->add($bonus);
                    break;
                case 'initiative':
                    $character->getAttackBonuses()->initiative->add($bonus);
                    break;
                case 'ac':
                    $character->getDefenseBonuses()->ac->add($bonus);
                    break;
                case 'spell-resistance':
                    $character->getDefenseBonuses()->spellResitance->add($bonus);
                    break;
                case 'cmb':
                    $character->getAttackBonuses()->cmb->add($bonus);
                    break;
                case 'cmd':
                    $character->getAttackBonuses()->cmd->add($bonus);
                    break;
                case 'melee-attack-roll':
                    $character->getAttackBonuses()->meleeAttackRolls->add($bonus);
                    break;
                case 'melee-damage-roll':
                    $character->getAttackBonuses()->meleeDamage->add($bonus);
                    break;
                case 'melee-attacks':
                    $character->getAttackBonuses()->meleeAttacks->add($bonus);
                    break;
                case 'ranged-attack-roll':
                    $character->getAttackBonuses()->rangedAttackRolls->add($bonus);
                    break;
                case 'ranged-damage-roll':
                    $character->getAttackBonuses()->rangedDamage->add($bonus);
                    break;
                case 'ranged-attacks':
                    $character->getAttackBonuses()->rangedAttacks->add($bonus);
                    break;
                case 'acrobatics':
                case 'appraise':
                case 'bluff':
                case 'climb':
                case 'craft':
                case 'diplomacy':
                case 'disable-device':
                case 'disguise':
                case 'escape-artist':
                case 'fly':
                case 'handle-animal':
                case 'heal':
                case 'intimidate':
                case 'knowledge-arcana':
                case 'knowledge-dungeoneering':
                case 'knowledge-geography':
                case 'knowledge-history':
                case 'knowledge-local':
                case 'knowledge-nature':
                case 'knwoledge-nobility':
                case 'knowledge-planes':
                case 'knowledge-religion':
                case 'linguistics':
                case 'perception':
                case 'perform':
                case 'profession':
                case 'ride':
                case 'sense-motive':
                case 'sleight-of-hand':
                case 'spellcraft':
                case 'stealth':
                case 'survival':
                case 'swim':
                case 'use-magic-device':
                    if (!array_key_exists($stat, $character->getSkillsBonuses())) {
                        $character->getSkillsBonuses()[$stat] = new Bonuses();
                    }
                    /** @var $bonuses Bonuses */
                    $bonuses = $character->getSkillsBonuses()[$stat];
                    $bonuses->add($bonus);
                    break;
                case 'hp':
                    $character->getHpBonuses()->add($bonus);
                    break;
                case 'speed':
                    $character->getSpeedBonuses()->add($bonus);
                    break;
            }
        }

        return $character;
    }
} 
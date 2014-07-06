<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 06/07/14
 * Time: 18:28
 */

namespace Troulite\PathfinderBundle\Services;


/**
 * Class AbilityTools
 *
 * @package Troulite\PathfinderBundle\Services
 */
class AbilityTools
{
    /**
     * @param string $ability
     *
     * @return int
     */
    public function getModifierByAbility($ability, $character)
    {
        switch ($ability) {
            case 'strength':
                return $character->getAbilityModifier($character->getStrength());
            case 'dexterity':
                return $character->getAbilityModifier($character->getDexterity());
            case 'constitution':
                return $character->getAbilityModifier($character->getConstitution());
            case 'intelligence':
                return $character->getAbilityModifier($character->getIntelligence());
            case 'wisdom':
                return $character->getAbilityModifier($character->getWisdom());
            case 'charisma':
                return $character->getAbilityModifier($character->getCharisma());
        }
        return 0;
    }
} 
<?php

namespace App\EntityListener;

use App\Entity\Characters\Character;
use App\Services\CharacterBonuses;

/**
 * Class CharacterEntityListener
 *
 * @package App\Entity\Listener
 */
class CharacterEntityListener  {

    protected $characterBonuses;

    /**
     * @param CharacterBonuses $characterBonuses
     */
    public function __construct(CharacterBonuses $characterBonuses)
    {
        // Cannot pass or retrieve troulite_pathfinder.character_bonuses from here because of circular reference
        $this->characterBonuses = $characterBonuses;
    }

    /**
     * @param Character $character
     *
     * @internal param LifecycleEventArgs $event
     */
    public function postLoad(Character $character)
    {
        $character->postLoad();
        $this->characterBonuses->applyAll($character);
    }
}
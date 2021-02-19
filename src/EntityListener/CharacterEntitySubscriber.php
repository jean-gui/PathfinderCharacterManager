<?php

namespace App\EntityListener;

use App\Entity\Characters\Character;
use App\Entity\Characters\PreparedSpell;
use App\Entity\Rules\ClassDefinition;
use App\Services\CharacterBonuses;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class CharacterEntitySubscriber implements EventSubscriber {

    protected $characterBonuses;
    protected $extraSpells;

    /**
     * @param CharacterBonuses $characterBonuses
     */
    public function __construct(CharacterBonuses $characterBonuses, array $extraSpells)
    {
        $this->characterBonuses = $characterBonuses;
        $this->extraSpells      = $extraSpells;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::postLoad
        ];
    }

    public function postLoad(LifecycleEventArgs $event)
    {
        $character = $event->getEntity();
        if ($character instanceof Character) {
            $character->postLoad();
            $this->characterBonuses->applyAll($character);
        }
    }
}
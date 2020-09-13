<?php

namespace App\Entity\Listener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\Character;

/**
 * Class CharacterListener
 *
 * @package App\Entity\Listener
 */
class CharacterListener  {

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        // Cannot pass or retrieve troulite_pathfinder.character_bonuses from here because of circular reference
        $this->container = $container;
    }

    /**
     * @param Character $character
     *
     * @internal param LifecycleEventArgs $event
     */
    public function postLoad(Character $character)
    {
        $character->postLoad();
        $this->container->get('troulite_pathfinder.character_bonuses')->applyAll($character);
    }
}
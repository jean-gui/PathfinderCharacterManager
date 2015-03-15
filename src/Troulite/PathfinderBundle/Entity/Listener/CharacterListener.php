<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 13/03/15
 * Time: 17:02
 */

namespace Troulite\PathfinderBundle\Entity\Listener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Troulite\PathfinderBundle\Entity\Character;

/**
 * Class CharacterListener
 *
 * @package Troulite\PathfinderBundle\Entity\Listener
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
        $this->container->get('troulite_pathfinder.character_bonuses')->applyAll($character);
    }
}
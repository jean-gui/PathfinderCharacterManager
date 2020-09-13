<?php

namespace App\EntityListener;

use App\Entity\Counter;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class CounterEntityListener
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(Counter $counter, LifecycleEventArgs $event)
    {
        $counter->computeSlug($this->slugger);
    }

    public function preUpdate(Counter $counter, LifecycleEventArgs $event)
    {
        $counter->computeSlug($this->slugger);
    }
}
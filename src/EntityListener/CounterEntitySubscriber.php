<?php

namespace App\EntityListener;

use App\Entity\Characters\Counter;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\String\Slugger\SluggerInterface;

class CounterEntitySubscriber implements EventSubscriber
{
    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::preUpdate
        ];
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $counter = $event->getEntity();
        if ($counter instanceof Counter) {
            $counter->computeSlug($this->slugger);
        }
    }

    public function preUpdate(LifecycleEventArgs $event)
    {
        $counter = $event->getEntity();
        if ($counter instanceof Counter) {
            $counter->computeSlug($this->slugger);
        }
    }
}
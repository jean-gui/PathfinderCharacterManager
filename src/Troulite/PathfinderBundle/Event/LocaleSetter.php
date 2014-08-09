<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 09/08/14
 * Time: 21:42
 */

namespace Troulite\PathfinderBundle\Event;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Class LocaleSetter
 *
 * @package Troulite\PathfinderBundle\Event
 */
class LocaleSetter implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array('kernel.request' => array('setLocale'));
    }

    /**
     * @param GetResponseEvent $event
     */
    public function setLocale(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $request = $event->getRequest();

        if ($request->getLocale()) {
            if ($locale = $request->getSession()->get('_locale')) {
                $request->setLocale($locale);
            } else {
                $locale = $request->getPreferredLanguage();
                $request->setLocale($locale);
                $request->getSession()->set('_locale', $locale);
            }
        }
    }
}
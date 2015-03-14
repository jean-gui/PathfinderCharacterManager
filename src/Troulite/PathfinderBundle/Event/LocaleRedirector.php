<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 09/08/14
 * Time: 21:42
 */

namespace Troulite\PathfinderBundle\Event;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class LocaleRedirector
 *
 * @package Troulite\PathfinderBundle\Event
 */
class LocaleRedirector implements EventSubscriberInterface
{
    /**
     * @var string
     */
    private $defaultLocale;
    /**
     * @var string[]
     */
    private $acceptedLocales;

    /**
     * @param RouterInterface $router
     * @param string $defaultLocale
     * @param string $acceptedLocales
     */
    public function __construct(RouterInterface $router, $defaultLocale, $acceptedLocales)
    {
        $this->router          = $router;
        $this->defaultLocale   = $defaultLocale;
        $this->acceptedLocales = $acceptedLocales;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array('kernel.request' => array('redirectToLocale'));
    }

    /**
     * Redirect to localized URL if all these conditions are met:
     *  - user visits for the first time
     *  - user is visiting default website
     *  - user's locale is different from default one
     *  - user's locale matches an accepted one
     *
     * @param GetResponseEvent $event
     */
    public function redirectToLocale(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $request = $event->getRequest();
        $route = $request->get('_route');
        $locale = $request->getPreferredLanguage($this->acceptedLocales);

        if (!$request->getSession()->get('visiting_again') &&
            $request->attributes->get('_locale') === $this->defaultLocale &&
            $locale !== $this->defaultLocale &&
            in_array($locale, $this->acceptedLocales)
        ) {
            $url = $this->router->generate(
                $route,
                ['_locale' => $locale] + $request->attributes->get('_route_params')
            );

            $request->getSession()->set('visiting_again', true);
            $response = new RedirectResponse($url);
            $event->setResponse($response);
        }
    }
}
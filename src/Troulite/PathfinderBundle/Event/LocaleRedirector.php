<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 09/08/14
 * Time: 21:42
 */
/*
 * Copyright 2015 Jean-Guilhem Rouel
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Troulite\PathfinderBundle\Event;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
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
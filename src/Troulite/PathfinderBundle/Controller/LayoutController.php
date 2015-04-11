<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 15/03/15
 * Time: 16:38
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

namespace Troulite\PathfinderBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Intl\Intl;

/**
 * Class LayoutController
 *
 * @package Troulite\PathfinderBundle\Controller
 */
class LayoutController extends Controller
{
    /**
     * @Route("/layout/header", name="layout_header")
     * @Template()
     * @Method("GET")
     *
     * @param Request $request
     *
     * @return array
     */
    public function headerAction(Request $request)
    {
        $route       = $request->query->get('_route');
        $routeParams = $request->query->all();
        unset($routeParams['_route']);

        return array(
            'route'            => $route,
            'routeParams'      => $routeParams
        );
    }

    /**
     * @Route("/layout/footer", name="layout_footer")
     * @Template()
     * @Method("GET")
     *
     * @param Request $request
     *
     * @return array
     */
    public function footerAction(Request $request)
    {
        $route = $request->query->get('_route');
        $routeParams = $request->query->all();
        unset($routeParams['_route']);
        $availableLocales = $this->container->getParameter('jms_i18n_routing.locales');
        $intl = Intl::getLanguageBundle();

        return array(
            'availableLocales' => $availableLocales,
            'intl' => $intl,
            'route' => $route,
            'routeParams' => $routeParams
        );
    }
}
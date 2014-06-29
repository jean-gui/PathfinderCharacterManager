<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 29/06/14
 * Time: 02:08
 */

namespace Troulite\PathfinderBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseSecurity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class SecurityController
 * @package Troulite\PathfinderBundle\Controller
 *
 */
class SecurityController extends BaseSecurity
{
    /**
     * @Route("/login", name="monlogin")
     * @Method("GET")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');

        return $this->container->get('templating')->renderResponse(
            '::navindicator.html.twig',
            array(
                'last_username' => null,
                'error' => null,
                'csrf_token' => $csrfToken
            )
        );
    }
}

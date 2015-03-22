<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 29/06/14
 * Time: 02:08
 */

namespace Troulite\PathfinderBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseSecurity;

/**
 * Class SecurityController
 * @package Troulite\PathfinderBundle\Controller
 *
 */
class SecurityController extends BaseSecurity
{
    /**
     * {@inheritdoc}
     */
    protected function renderLogin(array $data)
    {
        return $this->render('::navindicator.html.twig', $data);
    }
}

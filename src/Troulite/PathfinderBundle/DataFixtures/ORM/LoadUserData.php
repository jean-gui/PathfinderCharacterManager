<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 29/06/14
 * Time: 14:49
 */

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadUserData
 *
 * @package Troulite\PathfinderBundle\DataFixtures\ORM
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $jeangui = $userManager->createUser();
        $jeangui->setUsername('user1');
        $jeangui->setEmail('user1@example.com');
        $jeangui->setEnabled(true);
        $jeangui->setPlainPassword('***REMOVED***');
        $userManager->updateUser($jeangui);
        $this->setReference('user1', $jeangui);

        $user = $userManager->createUser();
        $user->setUsername('user5');
        $user->setEmail('jean-gui+kujar@troulite.fr');
        $user->setEnabled(true);
        $user->setPlainPassword('***REMOVED***');
        $userManager->updateUser($user);
        $this->setReference('user5', $user);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 5;
    }
}
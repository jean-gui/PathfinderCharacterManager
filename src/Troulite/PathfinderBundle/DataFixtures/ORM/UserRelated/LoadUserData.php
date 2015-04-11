<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 29/06/14
 * Time: 14:49
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

namespace Troulite\PathfinderBundle\DataFixtures\ORM\UserRelated\UserRelated;

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

        $user = $userManager->createUser();
        $user->setUsername('user1');
        $user->setEmail('user1@example.com');
        $user->setEnabled(true);
        $user->setPlainPassword('***REMOVED***');
        $userManager->updateUser($user);
        $this->setReference('user1', $user);

        $user = $userManager->createUser();
        $user->setUsername('user2');
        $user->setEmail('user2@example.com');
        $user->setEnabled(true);
        $user->setPlainPassword('***REMOVED***');
        $userManager->updateUser($user);
        $this->setReference('user2', $user);

        $user = $userManager->createUser();
        $user->setUsername('user3');
        $user->setEmail('user3@example.com');
        $user->setEnabled(true);
        $user->setPlainPassword('***REMOVED***');
        $userManager->updateUser($user);
        $this->setReference('user3', $user);

        $user = $userManager->createUser();
        $user->setUsername('user4');
        $user->setEmail('user4@example.com');
        $user->setEnabled(true);
        $user->setPlainPassword('***REMOVED***');
        $userManager->updateUser($user);
        $this->setReference('user4', $user);

        $user = $userManager->createUser();
        $user->setUsername('user5');
        $user->setEmail('user5@example.com');
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
        return 1;
    }
}
<?php
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

namespace Troulite\PathfinderBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\Security\Core\User\UserInterface;
use Troulite\PathfinderBundle\Entity\Party;
use Troulite\PathfinderBundle\Entity\User;

/**
 * Class PartyVoter
 *
 * @package Troulite\PathfinderBundle\Security\Authorization\Voter
 */
class PartyVoter extends AbstractVoter
{
    /**
     * Value for edit attribute
     */
    const EDIT = 'PARTY_EDIT';

    const DM_EDIT = 'DM_EDIT';

    /**
     * Return an array of supported attributes. This will be called by supportsAttribute
     *
     * @return array an array of supported attributes, i.e. array('CREATE', 'READ')
     */
    protected function getSupportedAttributes()
    {
        return array(self::EDIT, self::DM_EDIT);
    }

    /**
     * Return an array of supported classes. This will be called by supportsClass
     *
     * @return array an array of supported classes
     */
    protected function getSupportedClasses()
    {
        return array('Troulite\PathfinderBundle\Entity\Party');
    }

    /**
     * Perform a single access check operation on a given attribute, object and (optionally) user
     * It is safe to assume that $attribute and $object's class pass supportsAttribute/supportsClass
     * $user can be one of the following:
     *   a UserInterface object (fully authenticated user)
     *   a string               (anonymously authenticated user)
     *
     * @param string $attribute
     * @param Party $party
     * @param UserInterface|string $user
     *
     * @return bool
     */
    protected function isGranted($attribute, $party, $user = null)
    {
        // make sure there is a user object (i.e. that the user is logged in)
        if (!$user instanceof UserInterface) {
            return false;
        }

        // double-check that the User object is the expected entity (this
        // only happens when you did not configure the security system properly)
        if (!$user instanceof User) {
            throw new \LogicException('The user is somehow not our User class!');
        }

        switch ($attribute) {
            case self::EDIT:
                $userIds = array();
                if ($party->getDungeonMaster()) {
                    $userIds[] = $party->getDungeonMaster()->getId();
                }
                foreach ($party->getCharacters() as $character) {
                    $userIds[] = $character->getUser()->getId();
                }

                return in_array($user->getId(), $userIds);
            case self::DM_EDIT:
                return $party->getDungeonMaster() && ($user->getId() === $party->getDungeonMaster()->getId());
        }

        return false;
    }
}
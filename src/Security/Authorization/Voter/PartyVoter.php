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

namespace App\Security\Authorization\Voter;

use App\Entity\Party;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class PartyVoter
 *
 * @package Troulite\PathfinderBundle\Security\Authorization\Voter
 */
class PartyVoter extends Voter
{
    /**
     * Value for edit attribute
     */
    const EDIT = 'PARTY_EDIT';

    const DM_EDIT = 'DM_EDIT';

    protected function supports(string $attribute, $subject)
    {
        if (!in_array($attribute, [self::EDIT, self::DM_EDIT])) {
            return false;
        }

        if (!$subject instanceof Party) {
            return false;
        }

        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, object and (optionally) user
     * It is safe to assume that $attribute and $object's class pass supportsAttribute/supportsClass
     * $user can be one of the following:
     *   a UserInterface object (fully authenticated user)
     *   a string               (anonymously authenticated user)
     *
     * @param string         $attribute
     * @param $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        // make sure there is a user object (i.e. that the user is logged in)
        if (!$user instanceof User) {
            return false;
        }

        /** @var Party $party */
        $party = $subject;

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
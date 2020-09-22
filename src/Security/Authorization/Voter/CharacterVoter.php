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

use App\Entity\Characters\Character;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CharacterVoter extends Voter
{
    /**
     * Value for edit attribute
     */
    const EDIT = 'CHARACTER_EDIT';

    protected function supports(string $attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::EDIT])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof Character) {
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

        /** @var Character $character */
        $character = $subject;

        switch ($attribute) {
            case self::EDIT:
                return
                    $user->getId() === $character->getUser()->getId() ||
                    (
                        $character->getParty() &&
                        $character->getParty()->getDungeonMaster() &&
                        $user->getId() === $character->getParty()->getDungeonMaster()->getId()
                    )
                ;
        }

        return false;
    }
}
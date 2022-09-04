<?php

namespace App\Security;

use App\Service\ProjectScopeProvider;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Tzunghaor\SettingsBundle\Model\SettingSectionAddress;

class SettingsVoter extends Voter
{
    public function __construct(private ProjectScopeProvider $projectScopeProvider) {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        // This is what a settings voter must support
        return $attribute === 'edit' && $subject instanceof SettingSectionAddress;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        /** @var SettingSectionAddress $address */
        $address = $subject;
        $user = $token->getUser();

        // admins can edit any setting
        if (in_array('ROLE_ADMIN', $token->getRoleNames())) {
            return true;
        }

        // unauthenticated users are not allowed to edit any settings
        if ($user === null) {
            return false;
        }

        // non-admins can edit their own user settings
        if ($address->getCollectionName() === 'user') {
            if ($address->getScope() === null) {
                return true;
            }

            return $address->getScope() === $user->getUserIdentifier();
        }

        // non-admins can edit their own project settings
        if ($address->getCollectionName() === 'project') {
            if ($address->getScope() === null) {
                return true;
            }

            return $this->projectScopeProvider->doesScopeBelongToUser($address->getScope(), $user);
        }

        return false;
    }
}
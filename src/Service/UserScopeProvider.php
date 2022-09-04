<?php

namespace App\Service;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Tzunghaor\SettingsBundle\Model\Item;
use Tzunghaor\SettingsBundle\Service\ScopeProviderInterface;

class UserScopeProvider implements ScopeProviderInterface
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function getScope($subject = null): Item
    {
        if ($subject === null) {
            // If $subject is null then we should return the default scope: in this provider it is the current user.
            // You don't have to handle this case if you always specify the scope in editor route and your calls:
            // $settingsService->getSection(MySettings::class, 'myScope');
            $user = $this->security->getUser();
            $scope = $user->getUserIdentifier();
        } elseif (is_string($subject)) {
            // If $subject is string, we assume it is a user identifier - we could check here if user really exists.
            // This branch has to be implemented if you want to support scopes in editor route, or support calls like:
            // $settingsService->getSection(MySettings::class, 'myScope');
            $scope = $subject;
        } elseif ($subject instanceof UserInterface) {
            // You can handle any other $subject type, whatever you want to handle in your calls:
            // $settingsService->getSection(MySettings::class, $myObject);
            $scope = $subject->getUserIdentifier();
        } else {
            throw new \DomainException(get_class($subject) . ' is not supported as subject');
        }

        return new Item($scope);
    }

    public function getScopePath($subject = null): array
    {
        // User setting scopes inherit only from class default values, so we return empty array
        return [];
    }

    public function getScopeDisplayHierarchy(?string $searchString = null): ?array
    {
        // This method is only to list scopes in settings editor page, but we allow users to edit only their
        // own settings, so we can simply return empty array
        return [];
    }
}
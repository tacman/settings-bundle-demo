<?php

namespace App\Service;

use App\Model\Project;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Tzunghaor\SettingsBundle\Model\Item;
use Tzunghaor\SettingsBundle\Service\ScopeProviderInterface;

/**
 * Each user has a scope 'user.' . $userId with default settings,
 * and each project has scope 'project.' . $projectId with project overrides
 */
class ProjectScopeProvider implements ScopeProviderInterface
{
    private const USER_PREFIX = 'user';
    private const PROJECT_PREFIX = 'project';
    private const PREFIX_SEPARATOR = '.';

    /**
     * @var Project[]
     * This would normally come from some database
     */
    private array $projects;

    public function __construct(private Security $security, array $projects)
    {
        $this->projects = [];
        foreach ($projects as $id => $values) {
            $this->projects[] = new Project($id, $values['name'], $values['owner']);
        }
    }

    public function getScope($subject = null): Item
    {
        $item = null;

        if ($subject === null) {
            // default is currently logged-in user
            $user = $this->security->getUser();
            $userId = $user->getUserIdentifier();
            $item = new Item(self::USER_PREFIX . self::PREFIX_SEPARATOR . $userId, 'User ' . $userId);
        } if (is_string($subject)) {
            [$prefix, $id] = explode(self::PREFIX_SEPARATOR, $subject, 2);
            if ($prefix === self::USER_PREFIX) {
                // We could check $id if we had a list of all users
                $item = new Item($subject, 'User ' . $id);
            } elseif ($prefix === self::PROJECT_PREFIX) {
                // Check if scope has existing project
                $project = $this->findProject((int) $id);
                $item = new Item($subject, 'Project ' . $project->getName());
            }
        } elseif ($subject instanceof Project) {
            // We want to support $settingsService->getSection(ProjectSettings::class, $myProject) calls
            $project = $this->findProject($subject->getId());
            $item = new Item(
                self::PROJECT_PREFIX . self::PREFIX_SEPARATOR . $project->getId(),
                'Project ' . $project->getName())
            ;
        }

        if ($item === null) {
            throw new \DomainException('Scope not found');
        }

        return $item;
    }


    public function getScopePath($subject = null): array
    {
        $scopePath = null;

        if (is_string($subject)) {
            [$prefix, $id] = explode(self::PREFIX_SEPARATOR, $subject, 2);

            if ($prefix === self::USER_PREFIX) {
                // users inherit only from settings class => path is empty array
                $scopePath = [];
            } elseif ($prefix === self::PROJECT_PREFIX) {
                // Check if scope has existing project
                $project = $this->findProject((int) $id);
                $scopePath = [self::USER_PREFIX . self::PREFIX_SEPARATOR . $project->getOwner()];
            }
        } elseif ($subject instanceof Project) {
            $project = $this->findProject($subject->getId());
            $scopePath = [self::USER_PREFIX . self::PREFIX_SEPARATOR . $project->getOwner()];
        }

        if ($scopePath === null) {
            throw new \DomainException('Scope not found');
        }

        return $scopePath;
    }


    public function getScopeDisplayHierarchy(?string $searchString = null): ?array
    {
        return [];
    }

    /**
     * Return true if $scope is the given $user's default scope, or a project scope that belongs to $user
     */
    public function doesScopeBelongToUser(string $scope, UserInterface $user): bool
    {
        [$prefix, $id] = explode(self::PREFIX_SEPARATOR, $scope, 2);

        if ($prefix === self::USER_PREFIX) {
            return $id === $user->getUserIdentifier();
        }

        if ($prefix === self::PROJECT_PREFIX) {
            return $this->findProject($id)->getOwner() === $user->getUserIdentifier();
        }

        return false;
    }


    public function getProjects(): array
    {
        return $this->projects;
    }

    public function findProject(int $id): Project
    {
        foreach ($this->projects as $project) {
            if ($project->getId() === $id) {
                return $project;
            }
        }

        throw new \DomainException('There is no project with id ' . $id);
    }
}
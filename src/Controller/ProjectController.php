<?php

namespace App\Controller;

use App\Service\ProjectScopeProvider;
use App\Settings\Project\MainProjectSettings;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Tzunghaor\SettingsBundle\Service\SettingsService;

class ProjectController extends AbstractController
{
    public function __construct(
        private SerializerInterface  $serializer,
        private ProjectScopeProvider $projectProvider
    ) {
    }

    #[Route('/projects', name: 'app_projects')]
    public function index(
         ProjectScopeProvider $projectProvider): Response
    {
        return $this->render('project/index.html.twig', [
            'projects' => $projectProvider->getProjects(),
            'controller_name' => 'ProjectController',
        ]);
    }

    #[Route('/project/{projectId}', name: 'app_project')]
    #[Template('/project/show.html.twig')]
    public function project(
        SettingsService $projectSettings,
        Request         $request,
        int $projectId,
    ): Response|array
    {
        $currentProject = $this->projectProvider->findProject($projectId);
        foreach([MainProjectSettings::class] as $settingsClass) {
            $obj = $projectSettings->getSection($settingsClass, $currentProject);
            $class = (new \ReflectionClass($settingsClass))->getShortName();
            $settings[] = [
                'class' => $class,
                'settings' => json_decode($this->serializer->serialize($obj, 'json'), true),
                'route' => 'project_settings_edit',
                'routeParams' => ['section' => $class, 'scope' => $this->projectProvider->getScope($currentProject)->getName()],
            ];
        }

        return [
            'project' => $currentProject,
            'project_settings' => $settings,
            'settings' => $settings,
        ];
    }


}

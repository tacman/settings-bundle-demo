<?php

namespace App\Controller;

use App\Service\ProjectScopeProvider;
use App\Settings\Project\MainProjectSettings;
use App\Settings\System\BoxSettings;
use App\Settings\System\FunSettings;
use App\Settings\System\SadSettings;
use App\Settings\System\SiteSettings;
use App\Settings\User\UserSettings;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\SerializerInterface;
use Tzunghaor\SettingsBundle\Service\SettingsService;

class AppController extends AbstractController
{
    public function __construct(
        private SerializerInterface  $serializer,
        private ProjectScopeProvider $projectProvider
    ) {
    }


    /**
     * Three collections are defined in tzunghaor_settings.yaml: "system", "user" and "project", these have separate services.
     * The bundle adds auto-wiring rules, so $systemSettings as argument name will receive "system" collection's service.
     */
    #[Route('/', name: 'app_homepage')]
    public function index(
        SettingsService $systemSettings,
        SettingsService $userSettings,
        SettingsService $projectSettings,
        Request         $request
    ): Response {
        if ($request->query->has('project')) {
            $currentProject = $this->projectProvider->findProject((int) $request->query->get('project'));
        } else {
            $currentProject = null;
        }

        $settings = [
            'system' => [],
            'user' => [],
            'project' => [],
        ];
        // hack, not sure how to get all the setting classes.
//        foreach ([SiteSettings::class, BoxSettings::class, FunSettings::class, SadSettings::class] as $settingsClass) {


            foreach ([SiteSettings::class] as $settingsClass) {

                $obj = $systemSettings->getSection($settingsClass);
                $class = (new \ReflectionClass($settingsClass))->getShortName();
                $settings['system'][] = [
                    'class' => $class,
                    'settings' => json_decode($this->serializer->serialize($obj, 'json'), true),
                    'route' => 'system_settings_edit',
                    'routeParams' => ['section' => $class],
                ];
            }
            // user and project settings makes sense only if there is a logged in user
        if ($this->getUser() !== null) {
            foreach([UserSettings::class] as $settingsClass) {
                $obj = $userSettings->getSection($settingsClass);
                $class = (new \ReflectionClass($settingsClass))->getShortName();
                $settings['user'][] = [
                    'class' => $class,
                    'settings' => json_decode($this->serializer->serialize($obj, 'json'), true),
                    'route' => 'user_settings_edit',
                    'routeParams' => ['section' => $class],
                ];
            }

            if ($currentProject) {
                foreach([MainProjectSettings::class] as $settingsClass) {
                    $obj = $projectSettings->getSection($settingsClass, $currentProject);
                    $class = (new \ReflectionClass($settingsClass))->getShortName();
                    $settings['project'][] = [
                        'class' => $class,
                        'settings' => json_decode($this->serializer->serialize($obj, 'json'), true),
                        'route' => 'project_settings_edit',
                        'routeParams' => ['section' => $class, 'scope' => $this->projectProvider->getScope($currentProject)->getName()],
                    ];
                }
            }
        }

        return $this->render('app/index.html.twig', [
            'collectionSettings' => $settings,
            'systemSettings' => $systemSettings->getSection(SiteSettings::class),
            'projects' => $this->projectProvider->getProjects(),
            'currentProject' => $currentProject,
        ]);
    }

    /**
     * Example login controller from Symfony security documentation
     */
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         // get the login error if there is one
         $error = $authenticationUtils->getLastAuthenticationError();

         // last username entered by the user
         $lastUsername = $authenticationUtils->getLastUsername();

          return $this->render('app/login.html.twig', [
               'last_username' => $lastUsername,
               'error'         => $error,
          ]);
    }

    /**
     * Example logout controller from Symfony security documentation
     */
    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout()
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}

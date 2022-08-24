<?php

namespace App\Controller;

use App\Settings\BoxSettings;
use App\Settings\FunSettings;
use App\Settings\SadSettings;
use App\Settings\SiteSettings;
use App\Settings\UserSettings;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Tzunghaor\SettingsBundle\Service\SettingsEditorService;
use Tzunghaor\SettingsBundle\Service\SettingsService;

class AppController extends AbstractController
{
    public function __construct(private SerializerInterface $serializer) {

    }

    #[Route('/', name: 'app_homepage')]
    public function index(SettingsService $settings): Response
    {
        // hack, not sure how to get all the setting classes.
        foreach ([SiteSettings::class, BoxSettings::class, FunSettings::class, SadSettings::class, UserSettings::class] as $settingsClass) {
            $obj = $settings->getSection($settingsClass);
            $classSettings[(new \ReflectionClass($settingsClass))->getShortName()] = json_decode($this->serializer->serialize($obj, 'json'), true);
        }

//        $asArray = $this->serializer->serialize($siteSettings, 'yaml');
//        dd($asArray);
//        $siteSettingData = json_decode($this->serializer->serialize($siteSettings, 'json'), true);

        return $this->render('app/index.html.twig', [
            'classSettings' => $classSettings,
        ]);
    }
}

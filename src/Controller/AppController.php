<?php

namespace App\Controller;

use App\Settings\SiteSettings;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Tzunghaor\SettingsBundle\Service\SettingsService;

class AppController extends AbstractController
{
    public function __construct(private SerializerInterface $serializer) {

    }

    #[Route('/', name: 'app_homepage')]
    public function index(SettingsService $settings): Response
    {
        $siteSettings = $settings->getSection(SiteSettings::class);
//        $asArray = $this->serializer->serialize($siteSettings, 'yaml');
//        dd($asArray);
        $siteSettingData = json_decode($this->serializer->serialize($siteSettings, 'json'), true);

        return $this->render('app/index.html.twig', [
            'siteSettings' => $siteSettingData,
            'controller_name' => 'AppController',
        ]);
    }
}

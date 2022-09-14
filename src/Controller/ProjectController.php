<?php

namespace App\Controller;

use App\Service\ProjectScopeProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    #[Route('/project', name: 'app_project')]
    public function index(
         ProjectScopeProvider $projectProvider): Response
    {
        return $this->render('project/index.html.twig', [
            'projects' => $projectProvider->getProjects(),

            'controller_name' => 'ProjectController',
        ]);
    }
}

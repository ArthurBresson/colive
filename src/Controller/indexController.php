<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\EspaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class indexController extends AbstractController
{
    #[Route('/accueil', name: 'app_index')]
    public function index(EspaceRepository $espaceRepo): Response
    {
        return $this->render('index.html.twig',
            ['latestEspaces' => $espaceRepo->findLatest3()]);
    }
}

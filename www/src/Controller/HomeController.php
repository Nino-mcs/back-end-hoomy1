<?php

namespace App\Controller;

use App\Repository\VibeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(VibeRepository $vibeRepository): Response
    {
        $vibes = $vibeRepository->findAll();

        return $this->render('home/index.html.twig', [
            'vibes' => $vibes,
        ]);
    }
}

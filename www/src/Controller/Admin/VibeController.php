<?php

namespace App\Controller\Admin;

use App\Repository\VibeRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VibeController extends AbstractController
{
    #[Route('/vibe', name: 'app_vibe')]
    public function index(): Response
    {
        return $this->render('vibe/index.html.twig', [
            'controller_name' => 'VibeController',
        ]);
    }

    #[Route('hsojq', name: 'home')]
    public function homepage(VibeRepository $vibeRepository): Response
    {
        $vibes = $vibeRepository->findAll();

        return $this->render('vibe/index.html.twig', [
            'vibes' => $vibes
        ]);
    }

    #[Route('/api/profiles/{id}/vibes', name: 'api_profile_vibes', methods: ['GET'])]
    public function getVibesByProfile(int $id, VibeRepository $vibeRepository): JsonResponse
    {
        $vibes = $vibeRepository->findByProfileIdWithRelations($id);

        return $this->json($vibes, 200, [], ['groups' => 'vibe:read']);
    }
}

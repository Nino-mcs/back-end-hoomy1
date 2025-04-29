<?php

namespace App\Controller;

use App\Entity\Vibe;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class VibeController extends AbstractController
{
    #[Route('/api/vibe', name: 'api_add_vibe', methods: ['POST'])]
    public function addVibe(Request $request, ProfileRepository $profileRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $label = $data['label'] ?? null;
        $energy = $data['energy'] ?? null;
        $stress = $data['stress'] ?? null;
        $motivation = $data['motivation'] ?? null;
        $profileId = $data['profileId'] ?? null;



        if (!isset($label) || !isset($profileId) || !isset($energy) || !isset($stress) || !isset($motivation)) {
            return $this->json(['error' => 'données invalides'], 400);
        }

        $profile = $profileRepository->find($profileId);
        if (!$profile) {
            return $this->json(['error' => 'pièce non trouvée'], 404);
        }

        $vibe = new Vibe();
        $vibe->setLabel($label);
        $vibe->setEnergy($energy);
        $vibe->setStress($stress);
        $vibe->setMotivation($motivation);
        $vibe->setProfile($profile);

        try {
            $entityManager->persist($vibe);
            $entityManager->flush();
        } catch (\Exception $e) {
            return $this->json(['error' => 'Une erreur est survenue ' . $e->getMessage()], 500);
        }

        return $this->json(['success' => true, 'message' => 'Appareil ajouté avec succès !']);
    }
}

<?php

namespace App\Controller;

use App\Repository\ProfileRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileAuthController extends AbstractController
{
    #[Route('/api/login-profile', name: 'profile_login', methods: ['POST'])]
    public function login(Request $request, ProfileRepository $profileRepo): JsonResponse
    {
        // Récupère les données envoyées par le front-end
        $data = json_decode($request->getContent(), true);

        // Vérifie que les données nécessaires sont présentes
        $id = $data['id'] ?? null;
        $password = $data['password'] ?? null;

        if (!$id || !$password) {
            return new JsonResponse(['success' => false, 'message' => 'Données manquantes'], 400);
        }

        // Recherche le profil dans la base de données
        $profile = $profileRepo->findOneBy(['id' => $id]);

        if (!$profile) {
            return new JsonResponse(['success' => false, 'message' => 'Profil introuvable'], 404);
        }

        // Vérifie si le mot de passe est correct
        // Si vous utilisez un mot de passe haché, utilisez password_verify()
        if ($password != $profile->getPassword()) {
            return new JsonResponse(['success' => false, 'message' => 'Mot de passe incorrect'], 401);
        }

        // Retourne une réponse avec les informations du profil
        return new JsonResponse([
            'success' => true,
            'id' => $profile->getId(),
            'username' => $profile->getUsername(),
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Device;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeviceController extends AbstractController
{
    #[Route('/api/device', name: 'api_add_device', methods: ['POST'])]
    public function addDevice(Request $request, RoomRepository $roomRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $roomId = $data['roomId'] ?? null;
        $label = $data['label'] ?? null;
        $reference = $data['reference'] ?? null;

        if (!$roomId || !$label || !$reference) {
            return $this->json(['error' => 'données invalides'], 400);
        }

        $room = $roomRepository->find($roomId);
        if (!$room) {
            return $this->json(['error' => 'pièce non trouvée'], 404);
        }

        $device = new Device();
        $device->setLabel($label);
        $device->setReference($reference);
        $device->setRoom($room);
        $device->setStatus('active'); //todo

        try {
            $entityManager->persist($device);
            $entityManager->flush();
        } catch (\Exception $e) {
            return $this->json(['error' => 'Une erreur est survenue ' . $e->getMessage()], 500);
        }

        return $this->json(['success' => true, 'message' => 'Appareil ajouté avec succès !']);
    }
}

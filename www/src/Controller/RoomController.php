<?php
// filepath: src/Controller/RoomController.php
namespace App\Controller;

use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    #[Route('/api/room', name: 'api_room', methods: ['GET'])]
    public function getRooms(RoomRepository $roomRepository): JsonResponse
    {
        $rooms = $roomRepository->findAll();

        $data = array_map(function ($room) {
            return [
                'id' => $room->getId(),
                'label' => $room->getLabel(),

            ];
        }, $rooms);

        return $this->json($data);
    }
}

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


    #[Route('/api/room/{id}', name: 'api_room_detail', methods: ['GET'])]
    public function getRoomDetail(int $id, RoomRepository $roomRepository): JsonResponse
    {
        $room = $roomRepository->find($id);

        if (!$room) {
            return $this->json(['error' => 'Room not found'], 404);
        }

        $data = [
            'id' => $room->getId(),
            'label' => $room->getLabel(),
            'devices' => array_map(function ($device) {
                return [
                    'id' => $device->getId(),
                    'label' => $device->getLabel(),
                    'reference' => $device->getReference(),
                ];
            }, $room->getDevices()->toArray()),
        ];

        return $this->json($data);
    }
}

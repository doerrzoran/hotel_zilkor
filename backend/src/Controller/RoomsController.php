<?php

namespace App\Controller;

use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class RoomsController extends AbstractController
{
    private $roomRepository;

    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    #[Route('/backoffice/rooms', name: 'app_admin_rooms')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): JsonResponse
    {
        $rooms = $this->roomRepository->findAll();
        $groupedByHostel = [];

        foreach ($rooms as $room) {
            $hostel = $room->getHostel();
            $hostelCity = $hostel->getCity();

            if (!isset($groupedByHostel[$hostelCity])) {
                $groupedByHostel[$hostelCity] = [
                    'hostel' => $hostelCity,
                    'rooms' => []
                ];
            }
            $groupedByHostel[$hostelCity]['rooms'][] = [
                'id' => $room->getId(),
                'roomNumber' => $room->getRoomNumber(),
                'capacity' => $room->getCapacity(),
                'numberOfBed' => $room->getNumberOfBed(),
                'isAvailable' => $room->isAvialable(),
            ];
        }

        return new JsonResponse(array_values($groupedByHostel));
    }
}

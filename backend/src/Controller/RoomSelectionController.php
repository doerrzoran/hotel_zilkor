<?php

namespace App\Controller;

use App\Entity\Room;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class RoomSelectionController extends AbstractController
{
    private $bookingRepository;
    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;

    }
    #[Route('/room/selection', name: 'app_room_selection', methods: ['POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Vérifiez si les données nécessaires sont présentes
        if (!isset($data['hostelId']) || !isset($data['capacity']) || !isset($data['numberOfBeds'])) {
            return new JsonResponse(['error' => 'Missing required parameters'], 400);
        }

        $hostelId = $data['hostelId'];
        $capacity = $data['capacity'];
        $numberOfBeds = $data['numberOfBeds'];
        $arrivalDate = new \DateTime($data['arrivalDate']);
        $departureDate = new \DateTime($data['departureDate']);

        // Utilisez le repository pour effectuer une requête personnalisée
        $roomRepository = $entityManager->getRepository(Room::class);
        $availableRooms = $roomRepository->findAvailableRooms($hostelId, $capacity, $numberOfBeds);

        
        // Sérialisez les résultats
        $serializedRooms = [];
        foreach ($availableRooms as $room) {
            $serializedRooms[] = [
                'id' => $room->getId(),
                'Hotel' => $room->getHostel()->getId(),
                'roomNumber' => $room->getRoomNumber(),
                'capacity' => $room->getCapacity(),
                'numberOfBed' => $room->getNumberOfBed(),
                'isAvailable' => $room->isAvialable(),
            ];
        }

        return new JsonResponse($serializedRooms);
    }
}

<?php

namespace App\Controller;

use App\Entity\Room;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
        if (!isset($data['hostelId']) || !isset($data['capacity']) || !isset($data['numberOfBeds']) || !isset($data['arrivalDate']) || !isset($data['departureDate'])) {
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
        error_log('Available rooms before filtering: ' . count($availableRooms));
        
        $filteredRooms = [];

        foreach ($availableRooms as $room) {
            if ($this->isRoomAvailable($room, $arrivalDate, $departureDate)) {
                $filteredRooms[] = [
                    'id' => $room->getId(),
                    'Hotel' => $room->getHostel()->getId(),
                    'roomNumber' => $room->getRoomNumber(),
                    'capacity' => $room->getCapacity(),
                    'numberOfBed' => $room->getNumberOfBed(),
                    'isAvailable' => $room->isAvialable(),
                ];
            }
        }
        error_log('Filtered rooms: ' . count($filteredRooms));

        return new JsonResponse($filteredRooms);
    }

    private function isRoomAvailable(Room $room, \DateTime $arrivalDate, \DateTime $departureDate): bool
    {
        $availability = $room->getAviability();

        foreach ($availability as $period) {
            $start = \DateTime::createFromFormat('d/m/Y', $period['start']);
            $end = \DateTime::createFromFormat('d/m/Y', $period['end']);

            // Vérifiez si les dates ont été correctement analysées
            if (!$start || !$end) {
                continue; // Ignore invalid date formats in the availability periods
            }

            // Check if the requested period overlaps with the room's unavailable periods
            if ($arrivalDate <= $end && $departureDate >= $start) {
                return false;
            }
        }

        return true;
    }
}

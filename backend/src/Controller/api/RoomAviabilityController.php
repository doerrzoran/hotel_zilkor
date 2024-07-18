<?php

namespace App\Controller\api;

use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RoomAviabilityController extends AbstractController
{
    private $roomRepository;
    private $serializer;

    public function __construct(RoomRepository $roomRepository, SerializerInterface $serializer)
    {
        $this->roomRepository = $roomRepository;
        $this->serializer = $serializer;
    }

    #[Route('/room/aviability/{id}', name: 'api_room_aviability')]
    public function index($id): JsonResponse
    {
        $room = $this->roomRepository->find($id);

        $disponibility = $room->getBookings();
        $data = $this->serializer->serialize($disponibility, 'json');

        return new JsonResponse($data, JsonResponse::HTTP_OK, [], true);
    }
}

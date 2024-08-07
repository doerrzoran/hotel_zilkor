<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

class GuestBookingsController extends AbstractController
{
    #[Route('api/guest/bookings', name: 'api_guest_bookings')]
    #[IsGranted('ROLE_GUEST')]
    public function index(
        BookingRepository $bookingRepository,
        SerializerInterface $serializer
    ): JsonResponse
    {
        $user = $this->getUser();

        $bookings = $bookingRepository->findBy(['guest' => $user]);

        $data = $serializer->serialize($bookings, 'json');

        return new JsonResponse($data, JsonResponse::HTTP_OK, [], true);
    }
}

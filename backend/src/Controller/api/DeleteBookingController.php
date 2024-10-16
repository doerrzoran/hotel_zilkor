<?php

namespace App\Controller\api;

use App\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class DeleteBookingController extends AbstractController
{
    #[Route('/api/delete/booking', name: 'api_delete_booking', methods: ['DELETE'])]
    public function index(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $bookingId = $data['id'] ?? null;

        $booking = $entityManager->getRepository(Booking::class)->find($bookingId);

        if(!$booking){
            return new JsonResponse(['message' =>'Booking not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $entityManager->remove($booking);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Booking deleted successfully'], 200);
    }
}

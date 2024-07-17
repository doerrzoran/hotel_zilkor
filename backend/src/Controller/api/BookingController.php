<?php

namespace App\Controller\api;

use App\Entity\Booking;
use App\Form\BookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class BookingController extends AbstractController
{
    #[Route('/api/booking', name: 'api_booking', methods: ['POST'])]
    #[IsGranted('ROLE_GUEST')]
    public function book(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $jsonData = json_decode($request->getContent(), true);

        $booking = new Booking();

        $form = $this->createForm(BookingType::class, $booking);

        $form->submit($jsonData);

        if($form->isSubmitted() && $form->isValid()) {
            $departureDate = $form->get('depatureDate')->getData();
            $arrivalDate = $form->get('arrivalDate')->getData();
            $roomId = $form->get('room')->getData();

            $booking->setRoom($roomId);
            
            $booking->setGuest($this->getUser());
            
            $interval = $arrivalDate->diff($departureDate);
            $booking->setBookingPeriod(['days' => $interval->days]);
            $booking->setArrivalDate($arrivalDate);
            $booking->setDepatureDate($departureDate);
            $booking->setBookingPeriod(['days' => $interval, 'arrival' => $arrivalDate, 'depature' => $departureDate]);
            
            $booking->setActive(true);

            $entityManager->persist($booking);

            $entityManager->flush();

            return new JsonResponse(['message' => 'success'], 201);
            
        }

        $errors = $this->getFormErrors($form);
        
        return new JsonResponse($errors, 400);
    }

    private function getFormErrors(\Symfony\Component\Form\Form $form): array
    {
        $errors = [];
        foreach ($form->getErrors(true, true) as $error) {
            $errors[$error->getOrigin()->getName()][] = $error->getMessage();
        }

        return $errors;
    }
}

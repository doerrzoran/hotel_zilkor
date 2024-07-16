<?php

namespace App\Controller\api;

use App\Entity\Booking;
use App\Form\BookingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class BookingController extends AbstractController
{
    #[Route('/api/booking', name: 'api_booking')]
    #[IsGranted('ROLE_GUEST')]
    public function book(Request $request): JsonResponse
    {
        $jsonData = json_decode($request->getContent(), true);

        $booking = new Booking();

        $form = $this->createForm(BookingType::class, $booking);

        $form->submit($jsonData);

        if ($form->isSubmitted() && $form->isValid()) {
           
            
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

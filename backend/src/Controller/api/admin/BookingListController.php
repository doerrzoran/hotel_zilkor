<?php

namespace App\Controller\api\admin;

use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class BookingListController extends AbstractController
{
    private  $bookingRepository;
    private $serializer;

    public function __construct(BookingRepository $bookingRepository, SerializerInterface $serializer){
        $this->bookingRepository = $bookingRepository;
        $this->serializer = $serializer;
    }

    #[Route('/booking/list', name: 'app_booking_list')]
    public function index(): JsonResponse
    {
        $bookings = $this->bookingRepository->findAll();
        $jsonContent = $this->serializer->serialize($bookings, 'json');

        return new JsonResponse($jsonContent, JsonResponse::HTTP_OK, [], true);
    }
}

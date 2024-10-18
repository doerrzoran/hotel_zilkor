<?php

namespace App\Controller\api\admin;

use App\Repository\GuestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GuestsController extends AbstractController
{
    private $guestRepository;
    private $serializer;

    public function __construct(GuestRepository $guestRepository, SerializerInterface $serializer)
    {
        $this->guestRepository = $guestRepository;
        $this->serializer = $serializer;
    }

    #[Route('/api/backoffice/guests', name: 'app_guests')]
    public function index(): JsonResponse
    {
        $guests = $this->guestRepository->findAll();
        $jsonContent = $this->serializer->serialize($guests, 'json');

        return new JsonResponse($jsonContent, JsonResponse::HTTP_OK, [], true);
    }
}

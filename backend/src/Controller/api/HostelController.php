<?php

namespace App\Controller\api;

use App\Repository\HostelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class HostelController extends AbstractController
{
    private $hostelRepository;
    private $serializer;

    public function __construct(HostelRepository $hostelRepository, SerializerInterface $serializer)
    {
        $this->hostelRepository = $hostelRepository;
        $this->serializer = $serializer;
    }

    #[Route('/hostels', name: 'app_api_hostel')]
    public function index(): JsonResponse
    {
        $hostels = $this->hostelRepository->findAll();

        // Manually convert entities to arrays with only 'id' and 'city'
        $hostelArray = [];
        foreach ($hostels as $hostel) {
            $hostelData = [
                'id' => $hostel->getId(),
                'city' => $hostel->getCity()
            ];
            $hostelArray[] = $hostelData;
        }

        $data = $this->serializer->serialize($hostelArray, 'json');

        return new JsonResponse($data, JsonResponse::HTTP_OK, [], true);
    }
}

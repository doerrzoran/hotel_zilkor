<?php

namespace App\Controller;

use App\Repository\HostelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class HostelDetailController extends AbstractController
{
    private $hostelRepository;
    private $serializer;

    public function __construct(HostelRepository $hostelRepository, SerializerInterface $serializer)
    {
        $this->hostelRepository = $hostelRepository;
        $this->serializer = $serializer;
    }
    #[Route('/hostel/detail', name: 'app_api_hostel_detail')]
    public function index(): JsonResponse
    {
        $hostels = $this->hostelRepository->findAll();

        // Manually convert entities to arrays with only 'id' and 'city'
        $hostelArray = [];
        foreach ($hostels as $hostel) {
            $hostelData = [
                'city' => $hostel->getCity(),
                'description' => $hostel->getDescription(),
                'image' => $hostel->getImage(),
            ];
            $hostelArray[] = $hostelData;
        }

        $data = $this->serializer->serialize($hostelArray, 'json');

        return new JsonResponse($data, JsonResponse::HTTP_OK, [], true);
    }
}

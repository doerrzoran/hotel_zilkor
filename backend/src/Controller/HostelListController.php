<?php

namespace App\Controller;

use App\Repository\HostelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class HostelListController extends AbstractController
{
    private $hostelRepository;
    private $serializer;

    public function __construct(HostelRepository $hostelRepository, SerializerInterface $serializer)
    {
        $this->hostelRepository = $hostelRepository;
        $this->serializer = $serializer;
    }

    #[Route('/hostels/list', name: 'app_hostel_list')]
    public function index(): JsonResponse
    {
        $hostels = $this->hostelRepository->findAll();

        $data = $this->serializer->serialize($hostels, 
        'json', 
        ['groups' => ['hostel:read'],
        'circular_reference_handler' => function ($object) {
            return $object->getId();
        }]);
        
        return new JsonResponse($data, JsonResponse::HTTP_OK, [], true);
    }
}

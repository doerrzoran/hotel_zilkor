<?php

namespace App\Controller\api;

use App\Repository\HostelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
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

    #[Route('/hostel/{hostel}', name: 'app_api_hostel')]
    // #[IsGranted('ROLE_GUEST')]
    public function index($hostel): JsonResponse
    {
        $hostel = $this->hostelRepository->find($hostel);

        $data = $this->serializer->serialize($hostel, 
        'json', 
        ['groups' => ['hostel:read'],
        'circular_reference_handler' => function ($object) {
            return $object->getId();
        }]);
        
        return new JsonResponse($data, JsonResponse::HTTP_OK, [], true);
    }
}

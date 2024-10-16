<?php

namespace App\Controller\api\admin;

use App\Repository\HostelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
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

    #[Route('/api/backoffice/hostels/list', name: 'app_hostel_list')]
    // #[IsGranted('ROLE_ADMIN')]
    public function index(): JsonResponse
    {
        // Check if the user has the ROLE_ADMIN
        if (!$this->isGranted('ROLE_ADMIN')) {
            return new JsonResponse([
                'error' => 'Access Denied',
                'message' => 'You do not have the necessary permissions to access this resource.'
            ], JsonResponse::HTTP_FORBIDDEN);
        }
        
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

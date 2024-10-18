<?php

namespace App\Controller\api\admin;

use App\Entity\Hostel;
use App\Repository\HostelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddHostelController extends AbstractController
{
    #[Route('/api/backoffice/add/hostel', name: 'app_api_admin_add_hostel', methods: ['POST'])]
    public function newHostel(Request $request, HostelRepository $hostelRepository, EntityManagerInterface $manager): JsonResponse
    {
        $jsonData = json_decode($request->getContent(), true);

        // Ensure that required fields are present
        if (!isset($jsonData['country'], $jsonData['city'], $jsonData['description'], $jsonData['location'])) {
            return new JsonResponse(['error' => 'Missing required fields'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $country = $jsonData['country'];
        $city = $jsonData['city'];
        $description = $jsonData['description'];
        $location = $jsonData['location'];

        // Create a new hostel entity
        $hostel = new Hostel();
        $hostel->setCountry($country)
               ->setCity($city)
               ->setDescription($description)
               ->setLocation($location)
               ->setNumberOfRooms(0);


        // Persist and save the hostel
        $manager->persist($hostel);
        $manager->flush();

        // Return a success response
        return new JsonResponse(['message' => 'Hostel added successfully'], JsonResponse::HTTP_CREATED);
    }
}

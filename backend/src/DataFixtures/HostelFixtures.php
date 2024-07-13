<?php

namespace App\DataFixtures;

use App\Entity\Hostel;
use App\Entity\Manager;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;

class HostelFixtures extends Fixture implements OrderedFixtureInterface
{
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function load(ObjectManager $manager): void
    {
        $userRepository = $this->managerRegistry->getRepository(Manager::class);

        $managers = [
            'Paris' => $userRepository->findOneBy(['pseudo' => 'Bernard']),
            'New York' => $userRepository->findOneBy(['pseudo' => 'Walter']),
            'Marrakech' => $userRepository->findOneBy(['pseudo' => 'Kamal']),
            'Rio de Janeiro' => $userRepository->findOneBy(['pseudo' => 'Carla']),
            'Tokyo' => $userRepository->findOneBy(['pseudo' => 'Shinji']),
        ];

        $hostels = [
            [
                'location' => "30 rue de l'example",
                'city' => "Paris 5e",
                'country' => "France",
                'numberOfRooms' => 300,
                'manager' => $managers['Paris'],
            ],
            [
                'location' => "123 Broadway",
                'city' => "New York",
                'country' => "USA",
                'numberOfRooms' => 400,
                'manager' => $managers['New York'],
            ],
            [
                'location' => "Avenue Mohammed V",
                'city' => "Marrakech",
                'country' => "Morocco",
                'numberOfRooms' => 150,
                'manager' => $managers['Marrakech'],
            ],
            [
                'location' => "Copacabana Beach",
                'city' => "Rio de Janeiro",
                'country' => "Brazil",
                'numberOfRooms' => 250,
                'manager' => $managers['Rio de Janeiro'],
            ],
            [
                'location' => "Shibuya Crossing",
                'city' => "Tokyo",
                'country' => "Japan",
                'numberOfRooms' => 200,
                'manager' => $managers['Tokyo'],
            ],
            // Add more hostels here if needed
        ];

        foreach ($hostels as $hostelData) {
            if (!$hostelData['manager']) {
                throw new \Exception("Manager for {$hostelData['city']} not found.");
            }

            $hostel = new Hostel();
            $hostel
                ->setLocation($hostelData['location'])
                ->setCity($hostelData['city'])
                ->setCountry($hostelData['country'])
                ->setNumberOfRooms($hostelData['numberOfRooms'])
                ->setManager($hostelData['manager']);

            $manager->persist($hostel);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 3;
    }
}

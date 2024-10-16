<?php

namespace App\DataFixtures;

use App\Entity\Hostel;
use App\Entity\Manager;
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
                'description' => "Découvrez le charme de Paris dans notre auberge moderne située en plein cœur du 5e arrondissement, à quelques pas des monuments historiques et des cafés pittoresques. Une immersion authentique dans la capitale française.",
                'image' => 'hotel_paris.png', // Add image path
            ],
            [
                'location' => "123 Broadway",
                'city' => "New York",
                'country' => "USA",
                'numberOfRooms' => 400,
                'manager' => $managers['New York'],
                'description' => "Au cœur de la ville qui ne dort jamais, notre auberge de New York vous accueille à deux pas de Broadway et de Times Square. Profitez de l'effervescence de la Grosse Pomme dans un cadre confortable et convivial.",
                'image' => 'hotel_new_york.png', // Add image path
            ],
            [
                'location' => "Avenue Mohammed V",
                'city' => "Marrakech",
                'country' => "Morocco",
                'numberOfRooms' => 150,
                'manager' => $managers['Marrakech'],
                'description' => "Plongez dans la magie de Marrakech et découvrez le mélange unique de tradition et de modernité. Notre auberge, située sur l'avenue Mohammed V, vous offrira une expérience inoubliable au cœur de la ville rouge.",
                'image' => 'hotel_marakech.png', // Add image path
            ],
            [
                'location' => "Copacabana Beach",
                'city' => "Rio de Janeiro",
                'country' => "Brazil",
                'numberOfRooms' => 250,
                'manager' => $managers['Rio de Janeiro'],
                'description' => "Située face à la célèbre plage de Copacabana, notre auberge à Rio de Janeiro vous promet une ambiance festive et détendue. Profitez de la plage, du soleil et de la samba brésilienne dans un cadre exceptionnel.",
                'image' => 'hotel_rio_de_janeiro.png', // Add image path
            ],
            [
                'location' => "Shibuya Crossing",
                'city' => "Tokyo",
                'country' => "Japan",
                'numberOfRooms' => 200,
                'manager' => $managers['Tokyo'],
                'description' => "Plongez dans l'effervescence de Tokyo depuis notre auberge située à Shibuya, l'un des quartiers les plus dynamiques de la ville. Découvrez le contraste saisissant entre tradition et modernité au cœur de la capitale japonaise.",
                'image' => 'hotel_tokyo.png', // Add image path
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
                ->setManager($hostelData['manager'])
                ->setDescription($hostelData['description'])
                ->setImage($hostelData['image']); // Add image

            $manager->persist($hostel);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 3;
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Room;
use App\Entity\Hostel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class RoomFixture extends Fixture implements OrderedFixtureInterface
{
    private $managerRegistry;
    private SluggerInterface $slugger;

    public function __construct(ManagerRegistry $managerRegistry, SluggerInterface $slugger)
    {
        $this->managerRegistry = $managerRegistry;
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $hostelRepository = $this->managerRegistry->getRepository(Hostel::class);
        $hostels = $hostelRepository->findAll();

        $descriptions = [
            "A cozy room with a balcony and a great view",
            "A spacious room with a king-size bed and modern amenities",
            "A budget-friendly room with all basic necessities",
            "A luxury suite with a private bathroom and a mini-bar",
            "A comfortable room with a city view and fast Wi-Fi"
        ];

        $prices = [
            100, // Budget
            150, // Mid-range
            200, // High-end
            300  // Luxury
        ];

        $cityImages = [
            'paris 5e' => 'chambre_hotel_paris.jpg',
            'new york' => 'chambre_new_york.png',
            'marrakech' => 'chambre_marakech.png',
            'rio de janeiro' => 'chambre_rio.png',
            'tokyo' => 'chambre_tokyo.png'
        ];

        foreach ($hostels as $hostel) {
            $city = strtolower($hostel->getCity());
            $image = $cityImages[$city];
            for ($i = 1; $i <= $hostel->getNumberOfRooms(); $i++) {
                $room = new Room();
                $room
                    ->setHostel($hostel)
                    ->setRoomNumber($i)
                    ->setImage($image)
                    ->setDescription($descriptions[array_rand($descriptions)])
                    ->setPrice($prices[array_rand($prices)])
                    ->setCapacity(rand(1, 4)) 
                    ->setNumberOfBed(rand(1, 4)) 
                    ->setAvialable(true); 

                $manager->persist($room);
            }
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 4;
    }
}

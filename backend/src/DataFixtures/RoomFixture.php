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

        foreach ($hostels as $hostel) {
            for ($i = 1; $i <= $hostel->getNumberOfRooms(); $i++) {
                $room = new Room();
                $room
                    ->setHostel($hostel)
                    ->setRoomNumber($i)
                    ->setImage(strtolower($this->slugger->slug('chambre_hotel_paris')) . '.jpg')
                    ->setCapacity(rand(1, 4)) // Random capacity between 1 and 4
                    ->setNumberOfBed(rand(1, 4)) // Random number of beds between 1 and 4
                    ->setAvialable(true); // Assuming all rooms are available initially

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

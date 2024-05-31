<?php

namespace App\DataFixtures;

use App\Entity\Room;
use App\Entity\Hostel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

class RoomFixture extends Fixture implements OrderedFixtureInterface
{
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
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
        return 5;
    }
}

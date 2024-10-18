<?php

namespace App\Tests\EventListener;

use App\Entity\Booking;
use App\Entity\Guest;
use App\Entity\Room;
use App\EventListener\BookingListener;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BookingListenerTest extends KernelTestCase
{
    public function testPostPersist(): void
    {
        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $listener = new BookingListener($entityManager);

        $subscribedEvents = $listener->getSubscribedEvents();

        $this->assertContains(Events::postPersist, $subscribedEvents);

        // Retrieve an existing room
        $room = $entityManager->getRepository(Room::class)->findOneBy(['roomNumber' => 105]);

        if (!$room) {
            $this->fail('No room found with room number 102');
        }

        $guest = new Guest();
        $guest->setEmail('test4@example.com');
        $guest->setPassword('password');
        $guest->setPseudo('testguest');
        $guest->setName('Test');
        $guest->setFirstname('Guest');

        $entityManager->persist($guest);

        $booking = new Booking();
        $booking->setRoom($room);
        $booking->setArrivalDate(new \DateTime('2024-07-18'));
        $booking->setdepartureDate(new \DateTime('2024-07-20'));
        $booking->setGuest($guest);
        $booking->setActive(true);

        $entityManager->persist($booking);
        $entityManager->flush();

        $listener->postPersist(new PostPersistEventArgs($booking, $entityManager));

        $entityManager->refresh($room);

        $availability = $room->getAviability();

        $expectedAvailability = [
            [
                'start' => '18/07/2024',
                'end' => '20/07/2024',
            ]
        ];

        $this->assertCount(1, $availability);
        $this->assertEquals($expectedAvailability, $availability);
    }
}

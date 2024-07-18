<?php

// src/EventListener/BookingListener.php

namespace App\EventListener;

use App\Entity\Booking;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;

class BookingListener implements EventSubscriber
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return string[]
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
        ];
    }

    public function postPersist(PostPersistEventArgs $event): void
    {
        $booking = $event->getObject();
        if ($booking instanceof Booking) {
            $room = $booking->getRoom();
            $availability = $room->getAviability();

            $newAvailability = [
                'start' => $booking->getArrivalDate()->format('d/m/Y'),
                'end' => $booking->getDepatureDate()->format('d/m/Y')
            ];

            foreach ($availability as $period) {
                if ($period['start'] === $newAvailability['start'] && $period['end'] === $newAvailability['end']) {
                    return;
                }
            }
            $availability[] = $newAvailability;
            $room->setAviability($availability);
            $this->entityManager->flush();
        }
    }
}

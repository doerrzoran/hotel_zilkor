<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $guest = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?room $room = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $arrivalDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $depatureDate = null;

    #[ORM\Column]
    private array $bookingPeriod = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGuest(): ?user
    {
        return $this->guest;
    }

    public function setGuest(?user $guest): static
    {
        $this->guest = $guest;

        return $this;
    }

    public function getRoom(): ?room
    {
        return $this->room;
    }

    public function setRoom(?room $room): static
    {
        $this->room = $room;

        return $this;
    }

    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(\DateTimeInterface $arrivalDate): static
    {
        $this->arrivalDate = $arrivalDate;

        return $this;
    }

    public function getDepatureDate(): ?\DateTimeInterface
    {
        return $this->depatureDate;
    }

    public function setDepatureDate(\DateTimeInterface $depatureDate): static
    {
        $this->depatureDate = $depatureDate;

        return $this;
    }

    public function getBookingPeriod(): array
    {
        return $this->bookingPeriod;
    }

    public function setBookingPeriod(array $bookingPeriod): static
    {
        $this->bookingPeriod = $bookingPeriod;

        return $this;
    }
}

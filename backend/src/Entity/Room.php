<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('hostel:read')]
    private ?int $id = null;

    #[MaxDepth(1)]
    #[ORM\ManyToOne(inversedBy: 'rooms')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('hostel:read')]
    private ?Hostel $hostel = null;

    #[ORM\Column]
    #[Groups('hostel:read')]
    private ?int $roomNumber = null;

    #[ORM\Column]
    #[Groups('hostel:read')]
    private ?int $capacity = null;

    #[ORM\Column]
    #[Groups('hostel:read')]
    private ?int $numberOfBed = null;

    #[ORM\Column]
    #[Groups('hostel:read')]
    private ?bool $isAvialable = null;

    /**
     * @var Collection<int, Booking>
     */
    #[ORM\OneToMany(targetEntity: Booking::class, mappedBy: 'room')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('hostel:read')]
    private Collection $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHostel(): ?Hostel
    {
        return $this->hostel;
    }

    public function setHostel(?Hostel $hostel): static
    {
        $this->hostel = $hostel;

        return $this;
    }

    public function getRoomNumber(): ?int
    {
        return $this->roomNumber;
    }

    public function setRoomNumber(int $roomNumber): static
    {
        $this->roomNumber = $roomNumber;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getNumberOfBed(): ?int
    {
        return $this->numberOfBed;
    }

    public function setNumberOfBed(int $numberOfBed): static
    {
        $this->numberOfBed = $numberOfBed;

        return $this;
    }

    public function isAvialable(): ?bool
    {
        return $this->isAvialable;
    }

    public function setAvialable(bool $isAvialable): static
    {
        $this->isAvialable = $isAvialable;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): static
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setRoom($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getRoom() === $this) {
                $booking->setRoom(null);
            }
        }

        return $this;
    }
}

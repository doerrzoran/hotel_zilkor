<?php

namespace App\Entity;

use App\Repository\HostelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: HostelRepository::class)]
class Hostel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('hostel:read')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    /**
     * @var Collection<int, Room>
     */
    #[ORM\OneToMany(targetEntity: Room::class, mappedBy: 'hostel', orphanRemoval: true)]
    #[Groups('hostel:read')]
    private Collection $rooms;

    #[ORM\Column(length: 255)]
    #[Groups('hostel:read')]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    #[Groups('hostel:read')]
    private ?string $country = null;

    #[ORM\Column]
    #[Groups('hostel:read')]
    private ?int $numberOfRooms = null;

    #[ORM\OneToOne(inversedBy: 'hostel', cascade: ['persist', 'remove'])]
    #[Groups('hostel:read')]
    private ?Manager $manager = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('hostel:read')]
    #[Gedmo\Slug(fields: ['city'])]
    private ?string $slug = null;

    public function __construct()
    {
        $this->rooms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection<int, Room>
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(Room $room): static
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms->add($room);
            $room->setHostel($this);
        }

        return $this;
    }

    public function removeRoom(Room $room): static
    {
        if ($this->rooms->removeElement($room)) {
            // set the owning side to null (unless already changed)
            if ($room->getHostel() === $this) {
                $room->setHostel(null);
            }
        }

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getNumberOfRooms(): ?int
    {
        return $this->numberOfRooms;
    }

    public function setNumberOfRooms(int $numberOfRooms): static
    {
        $this->numberOfRooms = $numberOfRooms;

        return $this;
    }

    public function getManager(): ?Manager
    {
        return $this->manager;
    }

    public function setManager(?Manager $manager): static
    {
        $this->manager = $manager;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}

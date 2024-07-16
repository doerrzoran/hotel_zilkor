<?php

namespace App\Entity;

use App\Repository\ManagerRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: ManagerRepository::class)]
class Manager extends User
{

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Gedmo\Slug(fields: ['pseudo'])]
    private ?string $slug = null;

    #[ORM\OneToOne(mappedBy: 'manager', cascade: ['persist', 'remove'])]
    #[MaxDepth(1)]
    private ?Hostel $hostel = null;

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getHostel(): ?Hostel
    {
        return $this->hostel;
    }

    public function setHostel(?Hostel $hostel): static
    {
        // unset the owning side of the relation if necessary
        if ($hostel === null && $this->hostel !== null) {
            $this->hostel->setManager(null);
        }

        // set the owning side of the relation if necessary
        if ($hostel !== null && $hostel->getManager() !== $this) {
            $hostel->setManager($this);
        }

        $this->hostel = $hostel;

        return $this;
    }
}

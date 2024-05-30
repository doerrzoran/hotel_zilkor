<?php

namespace App\DataFixtures;

use App\Entity\Hostel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HostelFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $hostel = new Hostel();
        // ->setLocation($this->getReference("30 rue de l'example"))
        // ->setCity($this->getReference("Paris 5e"))
        // ->setCountry($this->getReference("France"))
        // ->setManager();

        // $manager->flush();
    }
}

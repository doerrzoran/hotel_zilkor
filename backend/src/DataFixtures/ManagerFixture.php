<?php

namespace App\DataFixtures;

use App\Entity\Manager;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ManagerFixture extends Fixture implements OrderedFixtureInterface
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {


        $hostelManager = new Manager();
        $hostelManager
        ->setPseudo("Bernard")
        ->setName("Bernard")
        ->setFirstname("Bernard")
        ->setRoles(["ROLE_MANAGER"])
        ->setEmail("Bernard@mail.com")
        ->setPassword($this->hasher->hashPassword($hostelManager, "Bernard:pw2"));
        $manager->persist($hostelManager);

        $hostelManager = new Manager();
        $hostelManager
        ->setPseudo("Walter")
        ->setName("Walter")
        ->setFirstname("Walter")
        ->setRoles(["ROLE_MANAGER"])
        ->setEmail("Walter@mail.com")
        ->setPassword($this->hasher->hashPassword($hostelManager, "Walter:pw2"));
        $manager->persist($hostelManager);

        $hostelManager = new Manager();
        $hostelManager
        ->setPseudo("Kamal")
        ->setName("Kamal")
        ->setFirstname("Kamal")
        ->setRoles(["ROLE_MANAGER"])
        ->setEmail("Kamal@mail.com")
        ->setPassword($this->hasher->hashPassword($hostelManager, "Kamal:pw2"));
        $manager->persist($hostelManager);

        $hostelManager = new Manager();
        $hostelManager
        ->setPseudo("Carla")
        ->setName("Carla")
        ->setFirstname("Carla")
        ->setRoles(["ROLE_MANAGER"])
        ->setEmail("Carla@mail.com")
        ->setPassword($this->hasher->hashPassword($hostelManager, "Carla:pw2"));
        $manager->persist($hostelManager);

        $hostelManager = new Manager();
        $hostelManager
        ->setPseudo("Shinji")
        ->setName("Shinji")
        ->setFirstname("Shinji")
        ->setRoles(["ROLE_MANAGER"])
        ->setEmail("Shinji@mail.com")
        ->setPassword($this->hasher->hashPassword($hostelManager, "Shinji:pw2"));
        $manager->persist($hostelManager);
        
        $manager->flush();
    }

    public function getOrder():int
    {
        return 2;
    }
}

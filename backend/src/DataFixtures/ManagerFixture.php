<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

class ManagerFixture extends Fixture implements OrderedFixtureInterface
{
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }
    
    public function load(ObjectManager $manager): void
    {
        $roleRepository = $this->managerRegistry->getRepository(Role::class);
        $managerRole = $roleRepository->findOneBy([ 'title' => 'manager']);

        if (!$managerRole) {
            throw new \Exception('Manager role not found. Make sure RolesFixtures are loaded first.');
        }

        $hostelManager = new User();
        $hostelManager
        ->setUsername("Bernard")
        ->setRole($managerRole)
        ->setRoles(["Role_Manager"])
        ->setEmail("Bernard@mail.com")
        ->setPassword("Bernard:pw2");
        $manager->persist($hostelManager);

        $hostelManager = new User();
        $hostelManager
        ->setUsername("Walter")
        ->setRole($managerRole)
        ->setRoles(["Role_Manager"])
        ->setEmail("Walter@mail.com")
        ->setPassword("Walter:pw2");
        $manager->persist($hostelManager);

        $hostelManager = new User();
        $hostelManager
        ->setUsername("Kamal")
        ->setRole($managerRole)
        ->setRoles(["Role_Manager"])
        ->setEmail("Kamal@mail.com")
        ->setPassword("Kamal:pw2");
        $manager->persist($hostelManager);

        $hostelManager = new User();
        $hostelManager
        ->setUsername("Carla")
        ->setRole($managerRole)
        ->setRoles(["Role_Manager"])
        ->setEmail("Carla@mail.com")
        ->setPassword("Carla:pw2");
        $manager->persist($hostelManager);

        $hostelManager = new User();
        $hostelManager
        ->setUsername("Shinji")
        ->setRole($managerRole)
        ->setRoles(["Role_Manager"])
        ->setEmail("Shinji@mail.com")
        ->setPassword("Shinji:pw2");
        $manager->persist($hostelManager);
        
        $manager->flush();
    }

    public function getOrder():int
    {
        return 3;
    }
}

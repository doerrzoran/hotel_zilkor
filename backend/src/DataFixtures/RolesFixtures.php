<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RolesFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $role = new Role();
        $role->setTitle("admin");
        $manager->persist($role);

        $role = new Role();
        $role->setTitle("manager");
        $manager->persist($role);

        $role = new Role();
        $role->setTitle("user");
        $manager->persist($role);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 1;
    }
}

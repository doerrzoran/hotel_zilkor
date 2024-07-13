<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture implements OrderedFixtureInterface
{
    private UserPasswordHasherInterface $hasher;
    
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {


        $admin = new Admin();
        $admin->setPseudo('Administrateur')
             ->setRoles(["ROLE_ADMIN"])
             ->setPassword($this->hasher->hashPassword($admin, "Admin:zilkor2"))
             ->setEmail('doerrzoran@gmail.com');
        $manager->persist($admin);
        $manager->flush();
    }

    public function getOrder(): int
    {
        return 1;
    }
}

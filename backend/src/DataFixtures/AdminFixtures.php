<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;

class AdminFixtures extends Fixture implements OrderedFixtureInterface
{
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function load(ObjectManager $manager): void
    {
        $roleRepository = $this->managerRegistry->getRepository(Role::class);
        $adminRole = $roleRepository->findOneBy([ 'title' => 'admin']);

        if (!$adminRole) {
            throw new \Exception('Admin role not found. Make sure RolesFixtures are loaded first.');
        }

        $user = new User();
        $user->setUsername('doerrzoran')
             ->setRole($adminRole)
             ->setRoles(['Role_Admin'])
             ->setPassword('Kala:zilkor2')
             ->setEmail('doerrzoran@gmail.com');
        
        $manager->persist($user);
        $manager->flush();
    }

    public function getOrder(): int
    {
        return 2;
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Room;
use App\Entity\Hostel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class RoomFixture extends Fixture implements OrderedFixtureInterface
{
    private $managerRegistry;
    private SluggerInterface $slugger;

    public function __construct(ManagerRegistry $managerRegistry, SluggerInterface $slugger)
    {
        $this->managerRegistry = $managerRegistry;
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $hostelRepository = $this->managerRegistry->getRepository(Hostel::class);
        $hostels = $hostelRepository->findAll();

        $descriptions = [
            "Une chambre confortable avec balcon et une vue imprenable",
            "Une chambre spacieuse avec un lit king-size et des équipements modernes",
            "Une chambre économique avec toutes les commodités de base",
            "Une suite de luxe avec salle de bain privée et mini-bar",
            "Une chambre confortable avec vue sur la ville et Wi-Fi rapide",
            "Une chambre lumineuse et aérée avec une vue panoramique",
            "Une chambre intime parfaite pour une escapade romantique",
            "Une suite élégante avec une décoration contemporaine et un salon privé",
            "Une chambre idéale pour les familles avec plusieurs lits et un espace de jeu",
            "Une chambre moderne avec accès à un spa privé",
            "Une chambre simple avec un bon rapport qualité-prix, idéale pour les voyageurs solos",
            "Une chambre avec terrasse privée et vue sur le jardin",
            "Une suite royale avec jacuzzi et vue sur l'océan",
            "Une chambre calme et paisible, parfaite pour se détendre après une longue journée",
            "Une chambre pour voyageurs d'affaires avec bureau et connexion haut débit",
            "Une chambre située au dernier étage avec une vue époustouflante sur la ville",
            "Une suite présidentielle avec un grand salon et une salle à manger privée",
            "Une chambre avec accès direct à la piscine",
            "Une chambre cosy avec cheminée pour des nuits chaleureuses",
            "Une chambre avec une décoration traditionnelle, parfaite pour découvrir la culture locale",
            "Une chambre minimaliste avec tout le nécessaire pour un séjour confortable",
            "Une chambre offrant une vue imprenable sur les montagnes",
            "Une chambre romantique avec un grand lit à baldaquin",
            "Une chambre avec des œuvres d'art locales pour une immersion culturelle",
            "Une chambre avec grande baignoire et vue sur le coucher de soleil",
        ];

        $prices = [
            100, // Budget
            150, // Mid-range
            200, // High-end
            300  // Luxury
        ];

        $cityImages = [
            'paris 5e' => 'chambre_hotel_paris.jpg',
            'new york' => 'chambre_new_york.png',
            'marrakech' => 'chambre_marakech.png',
            'rio de janeiro' => 'chambre_rio.png',
            'tokyo' => 'chambre_tokyo.png'
        ];

        foreach ($hostels as $hostel) {
            $city = strtolower($hostel->getCity());
            $image = $cityImages[$city];
            for ($i = 1; $i <= $hostel->getNumberOfRooms(); $i++) {
                $room = new Room();
                $room
                    ->setHostel($hostel)
                    ->setRoomNumber($i)
                    ->setImage($image)
                    ->setDescription($descriptions[array_rand($descriptions)])
                    ->setPrice($prices[array_rand($prices)])
                    ->setCapacity(rand(1, 4)) 
                    ->setNumberOfBed(rand(1, 4)) 
                    ->setAvialable(true); 

                $manager->persist($room);
            }
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 4;
    }
}

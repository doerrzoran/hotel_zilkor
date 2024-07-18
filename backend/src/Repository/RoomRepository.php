<?php

namespace App\Repository;

use App\Entity\Room;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Room>
 */
class RoomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Room::class);
    }

    public function findAvailableRooms(int $hostelId, int $capacity, int $numberOfBeds)
    {
        $result = $this->createQueryBuilder('r')
            ->andWhere('r.hostel = :hostelId')
            ->andWhere('r.capacity >= :capacity')
            ->andWhere('r.numberOfBed >= :numberOfBeds')
            ->andWhere('r.isAvialable = true')
            ->setParameter('hostelId', $hostelId)
            ->setParameter('capacity', $capacity)
            ->setParameter('numberOfBeds', $numberOfBeds)
            ->getQuery()
            ->getResult();

            // error_log('findAvailableRooms result: ' . print_r($result, true));

    return $result;
    }

    //    /**
    //     * @return Room[] Returns an array of Room objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Room
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

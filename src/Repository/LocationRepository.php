<?php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PgSql\Lob;

/**
 * @extends ServiceEntityRepository<Location>
 */
class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    public function save(Location $location, bool $flush = false): void
    {
        $em = $this->getEntityManager();
        $em->persist($location);

        if ($flush) {
            $em->flush();
        }
    }

    public function findOneByName(string $name): ?Location
    {
        $qb = $this->createQueryBuilder('l');
        $qb->where('l.name = :name')
            ->setParameter('name', $name);

        $q = $qb->getQuery();
        return $q->getOneOrNullResult();
    }

    public function findAllWithForecasts()
    {
        return $this->createQueryBuilder('l')
            ->leftJoin('l.forecasts', 'f')
            ->addSelect(['l', 'f'])
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Location[] Returns an array of Location objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Location
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

<?php

namespace App\Repository;

use App\Entity\ShopPlace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShopPlace|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShopPlace|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShopPlace[]    findAll()
 * @method ShopPlace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopPlaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShopPlace::class);
    }

    // /**
    //  * @return ShopPlace[] Returns an array of ShopPlace objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ShopPlace
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

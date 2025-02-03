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

     /**
      * @return ShopPlace[] Returns an array of ShopPlace objects
      */
    public function findByItemsInList($shoppingList): array
    {
        return $this->createQueryBuilder('s')
            ->join('s.listItems', 'i')
            ->andWhere('i.shoppingList = :shoppingList')
            ->setParameter('shoppingList', $shoppingList)
            ->getQuery()
            ->getResult()
        ;
    }


}

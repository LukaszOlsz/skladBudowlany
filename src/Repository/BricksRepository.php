<?php

namespace App\Repository;

use App\Entity\Bricks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bricks|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bricks|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bricks[]    findAll()
 * @method Bricks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BricksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bricks::class);
    }

    // /**
    //  * @return Bricks[] Returns an array of Bricks objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bricks
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

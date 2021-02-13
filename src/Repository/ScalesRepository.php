<?php

namespace App\Repository;

use App\Entity\Scales;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Scales|null find($id, $lockMode = null, $lockVersion = null)
 * @method Scales|null findOneBy(array $criteria, array $orderBy = null)
 * @method Scales[]    findAll()
 * @method Scales[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScalesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Scales::class);
    }

    // /**
    //  * @return Scales[] Returns an array of Scales objects
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
    public function findOneBySomeField($value): ?Scales
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

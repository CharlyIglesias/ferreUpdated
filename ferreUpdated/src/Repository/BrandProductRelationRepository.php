<?php

namespace App\Repository;

use App\Entity\BrandProductRelation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BrandProductRelation|null find($id, $lockMode = null, $lockVersion = null)
 * @method BrandProductRelation|null findOneBy(array $criteria, array $orderBy = null)
 * @method BrandProductRelation[]    findAll()
 * @method BrandProductRelation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrandProductRelationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BrandProductRelation::class);
    }

    // /**
    //  * @return BrandProductRelation[] Returns an array of BrandProductRelation objects
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
    public function findOneBySomeField($value): ?BrandProductRelation
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

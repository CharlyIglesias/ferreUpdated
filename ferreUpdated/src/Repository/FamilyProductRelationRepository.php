<?php

namespace App\Repository;

use App\Entity\FamilyProductRelation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FamilyProductRelation|null find($id, $lockMode = null, $lockVersion = null)
 * @method FamilyProductRelation|null findOneBy(array $criteria, array $orderBy = null)
 * @method FamilyProductRelation[]    findAll()
 * @method FamilyProductRelation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FamilyProductRelationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FamilyProductRelation::class);
    }

    // /**
    //  * @return FamilyProductRelation[] Returns an array of FamilyProductRelation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FamilyProductRelation
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\Collocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Collocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collocation[]    findAll()
 * @method Collocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollocationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Collocation::class);
    }

    // /**
    //  * @return Collocation[] Returns an array of Collocation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Collocation
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

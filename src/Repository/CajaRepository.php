<?php

namespace App\Repository;

use App\Entity\Caja;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Caja|null find($id, $lockMode = null, $lockVersion = null)
 * @method Caja|null findOneBy(array $criteria, array $orderBy = null)
 * @method Caja[]    findAll()
 * @method Caja[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CajaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Caja::class);
    }

//    /**
//     * @return Caja[] Returns an array of Caja objects
//     */
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
    public function findOneBySomeField($value): ?Caja
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

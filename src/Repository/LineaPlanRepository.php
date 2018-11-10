<?php

namespace App\Repository;

use App\Entity\LineaPlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LineaPlan|null find($id, $lockMode = null, $lockVersion = null)
 * @method LineaPlan|null findOneBy(array $criteria, array $orderBy = null)
 * @method LineaPlan[]    findAll()
 * @method LineaPlan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LineaPlanRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LineaPlan::class);
    }

//    /**
//     * @return LineaPlan[] Returns an array of LineaPlan objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LineaPlan
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

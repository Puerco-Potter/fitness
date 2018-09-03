<?php

namespace App\Repository;

use App\Entity\RegistroMantenimiento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RegistroMantenimiento|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegistroMantenimiento|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegistroMantenimiento[]    findAll()
 * @method RegistroMantenimiento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegistroMantenimientoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RegistroMantenimiento::class);
    }

//    /**
//     * @return RegistroMantenimiento[] Returns an array of RegistroMantenimiento objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RegistroMantenimiento
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

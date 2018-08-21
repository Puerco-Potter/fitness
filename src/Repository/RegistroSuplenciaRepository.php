<?php

namespace App\Repository;

use App\Entity\RegistroSuplencia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RegistroSuplencia|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegistroSuplencia|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegistroSuplencia[]    findAll()
 * @method RegistroSuplencia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegistroSuplenciaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RegistroSuplencia::class);
    }

//    /**
//     * @return RegistroSuplencia[] Returns an array of RegistroSuplencia objects
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
    public function findOneBySomeField($value): ?RegistroSuplencia
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

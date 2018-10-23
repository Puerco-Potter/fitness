<?php

namespace App\Repository;

use App\Entity\Musculo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Musculo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Musculo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Musculo[]    findAll()
 * @method Musculo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MusculoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Musculo::class);
    }

//    /**
//     * @return Musculo[] Returns an array of Musculo objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Musculo
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\Elemento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Elemento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Elemento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Elemento[]    findAll()
 * @method Elemento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElementoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Elemento::class);
    }

//    /**
//     * @return Elemento[] Returns an array of Elemento objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Elemento
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

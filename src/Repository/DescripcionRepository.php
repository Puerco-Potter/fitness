<?php

namespace App\Repository;

use App\Entity\Descripcion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Descripcion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Descripcion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Descripcion[]    findAll()
 * @method Descripcion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DescripcionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Descripcion::class);
    }

//    /**
//     * @return Descripcion[] Returns an array of Descripcion objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Descripcion
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

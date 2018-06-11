<?php

namespace App\Repository;

use App\Entity\Equipamiento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Equipamiento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Equipamiento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Equipamiento[]    findAll()
 * @method Equipamiento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipamientoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Equipamiento::class);
    }

//    /**
//     * @return Equipamiento[] Returns an array of Equipamiento objects
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
    public function findOneBySomeField($value): ?Equipamiento
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

<?php

namespace App\Repository;

use App\Entity\PlanEntrenamiento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PlanEntrenamiento|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlanEntrenamiento|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlanEntrenamiento[]    findAll()
 * @method PlanEntrenamiento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanEntrenamientoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PlanEntrenamiento::class);
    }

//    /**
//     * @return PlanEntrenamiento[] Returns an array of PlanEntrenamiento objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlanEntrenamiento
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

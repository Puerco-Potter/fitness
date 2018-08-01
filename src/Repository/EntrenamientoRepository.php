<?php

namespace App\Repository;

use App\Entity\Entrenamiento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Entrenamiento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entrenamiento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entrenamiento[]    findAll()
 * @method Entrenamiento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrenamientoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Entrenamiento::class);
    }

//    /**
//     * @return Entrenamiento[] Returns an array of Entrenamiento objects
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
    public function findOneBySomeField($value): ?Entrenamiento
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

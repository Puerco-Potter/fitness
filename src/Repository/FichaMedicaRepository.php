<?php

namespace App\Repository;

use App\Entity\FichaMedica;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FichaMedica|null find($id, $lockMode = null, $lockVersion = null)
 * @method FichaMedica|null findOneBy(array $criteria, array $orderBy = null)
 * @method FichaMedica[]    findAll()
 * @method FichaMedica[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FichaMedicaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FichaMedica::class);
    }

//    /**
//     * @return FichaMedica[] Returns an array of FichaMedica objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FichaMedica
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

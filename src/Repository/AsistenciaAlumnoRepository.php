<?php

namespace App\Repository;

use App\Entity\AsistenciaAlumno;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AsistenciaAlumno|null find($id, $lockMode = null, $lockVersion = null)
 * @method AsistenciaAlumno|null findOneBy(array $criteria, array $orderBy = null)
 * @method AsistenciaAlumno[]    findAll()
 * @method AsistenciaAlumno[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AsistenciaAlumnoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AsistenciaAlumno::class);
    }

//    /**
//     * @return AsistenciaAlumno[] Returns an array of AsistenciaAlumno objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AsistenciaAlumno
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

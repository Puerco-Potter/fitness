<?php

namespace App\Repository;

use App\Entity\TelefonoAlumno;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TelefonoAlumno|null find($id, $lockMode = null, $lockVersion = null)
 * @method TelefonoAlumno|null findOneBy(array $criteria, array $orderBy = null)
 * @method TelefonoAlumno[]    findAll()
 * @method TelefonoAlumno[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TelefonoAlumnoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TelefonoAlumno::class);
    }

//    /**
//     * @return TelefonoAlumno[] Returns an array of TelefonoAlumno objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TelefonoAlumno
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

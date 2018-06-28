<?php

namespace App\Repository;

use App\Entity\TelefonoEmpleado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TelefonoEmpleado|null find($id, $lockMode = null, $lockVersion = null)
 * @method TelefonoEmpleado|null findOneBy(array $criteria, array $orderBy = null)
 * @method TelefonoEmpleado[]    findAll()
 * @method TelefonoEmpleado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TelefonoEmpleadoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TelefonoEmpleado::class);
    }

//    /**
//     * @return TelefonoEmpleado[] Returns an array of TelefonoEmpleado objects
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
    public function findOneBySomeField($value): ?TelefonoEmpleado
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

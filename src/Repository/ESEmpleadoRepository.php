<?php

namespace App\Repository;

use App\Entity\ESEmpleado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ESEmpleado|null find($id, $lockMode = null, $lockVersion = null)
 * @method ESEmpleado|null findOneBy(array $criteria, array $orderBy = null)
 * @method ESEmpleado[]    findAll()
 * @method ESEmpleado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ESEmpleadoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ESEmpleado::class);
    }

//    /**
//     * @return ESEmpleado[] Returns an array of ESEmpleado objects
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
    public function findOneBySomeField($value): ?ESEmpleado
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

<?php

namespace App\Repository;

use App\Entity\Combo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Combo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Combo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Combo[]    findAll()
 * @method Combo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComboRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Combo::class);
    }

//    /**
//     * @return Combo[] Returns an array of Combo objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Combo
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

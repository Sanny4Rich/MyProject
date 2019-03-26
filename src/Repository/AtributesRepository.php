<?php

namespace App\Repository;

use App\Entity\Atributes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Atributes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Atributes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Atributes[]    findAll()
 * @method Atributes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AtributesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Atributes::class);
    }

    // /**
    //  * @return Atributes[] Returns an array of Atributes objects
    //  */
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
    public function findOneBySomeField($value): ?Atributes
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

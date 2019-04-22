<?php

namespace App\Repository;

use App\Entity\Attribute;
use App\Entity\AttributeValues;
use App\Entity\Categories;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Entity\Category;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AttributeValues|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttributeValues|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttributeValues[]    findAll()
 * @method AttributeValues[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttributeValuesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AttributeValues::class);
    }

    public function getFilterByAttributes(Categories $category)
    {
        $filter = $this->createQueryBuilder('a')
            ->innerJoin(Product::class, 'p', 'WITH', 'a.product = p.id')
            ->leftJoin(Attribute::class, 'i', 'WITH', 'a.attribute = i.id')
            ->where('p.categories = :category')
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
        return $filter;
    }
    // /**
    //  * @return AttributeValues[] Returns an array of AttributeValues objects
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
    public function findOneBySomeField($value): ?AttributeValues
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

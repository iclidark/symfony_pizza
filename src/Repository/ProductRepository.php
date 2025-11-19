<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findBySearchQuery(string $query): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
    }

    public function countByCategory(): array
    {
        return $this->createQueryBuilder('p')
            ->select('c.name, COUNT(p.id) as product_count')
            ->join('p.category', 'c')
            ->groupBy('c.name')
            ->getQuery()
            ->getResult();
    }

    public function getAvailabilityRatio(): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.status, COUNT(p.id) as status_count')
            ->groupBy('p.status')
            ->getQuery()
            ->getResult();
    }
}

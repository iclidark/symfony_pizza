<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function getTotalSalesByMonth(): array
    {
        return $this->createQueryBuilder('o')
            ->select('SUBSTRING(o.createdAt, 1, 7) as month, SUM(o.total) as total_sales')
            ->where('o.status = :status')
            ->setParameter('status', 'delivered')
            ->groupBy('month')
            ->orderBy('month', 'DESC')
            ->getQuery()
            ->getResult();
    }
}

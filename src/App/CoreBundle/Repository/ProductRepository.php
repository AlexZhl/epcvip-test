<?php

namespace App\CoreBundle\Repository;

use App\CoreBundle\Entity\Product;
use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    public function getCustomersWithPendingProducts(\DateTime $datetime)
    {
        return $this->createQueryBuilder('p')
            ->where('p.status = ?1')
            ->andWhere('p.createdAt < ?2')
            ->andWhere('p.customer IS NOT NULL')
            ->groupBy('p.customer')
            ->setParameter(1, Product::STATUS_PENDING)
            ->setParameter(2, $datetime)
            ->getQuery()
            ->getResult();
    }
}

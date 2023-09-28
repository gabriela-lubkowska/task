<?php

namespace App\Repository;

use App\Entity\CurrencyOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CurrencyOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method CurrencyOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method CurrencyOrder[]    findAll()
 * @method CurrencyOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurrencyOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CurrencyOrder::class);
    }
}

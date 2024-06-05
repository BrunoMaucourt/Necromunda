<?php

namespace App\Repository;

use App\Entity\Ganger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ganger>
 */
class GangerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ganger::class);
    }

    public function findAliveByGang($gangId)
    {
        return $this->createQueryBuilder('g')
            ->where('g.gang = :gangId')
            ->andWhere('g.alive = true')
            ->setParameter('gangId', $gangId)
            ->getQuery()
            ->getResult();
    }
}
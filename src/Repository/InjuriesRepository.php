<?php

namespace App\Repository;

use App\Entity\Injury;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Injury>
 */
class InjuriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Injury::class);
    }

    public function findAllInjuriesByGang(int $gangId)
    {
        return $this->createQueryBuilder('g')
            ->leftjoin('g.victim', 'f')
            ->Where('f.gang = :gangId')
            ->setParameter('gangId', $gangId)
            ->groupBy('g.name')
            ->getQuery()
            ->getResult()
        ;
    }
}
<?php

namespace App\Repository;

use App\Entity\Loot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Loot>
 */
class LootRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Loot::class);
    }

        public function findActiveLootByGang(int $gangID): ?array
        {
            return $this->createQueryBuilder('l')
                ->where('l.active = 1')
                ->andWhere('l.gang = :gang')
                ->setParameter('gang', $gangID)
                ->getQuery()
                ->getResult()
            ;
        }
}

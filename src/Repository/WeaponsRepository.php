<?php

namespace App\Repository;

use App\Entity\Weapon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Weapon>
 */
class WeaponsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Weapon::class);
    }

    public function findAllWeaponsByGang(int $gangId)
    {
        return $this->createQueryBuilder('g')
            ->leftjoin('g.ganger', 'f')
            ->where('g.stash = :gangId')
            ->orWhere('f.gang = :gangId')
            ->setParameter('gangId', $gangId)
            ->getQuery()
            ->getResult()
        ;
    }
}
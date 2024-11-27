<?php

namespace App\Repository;

use App\Entity\Equipement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Equipement>
 */
class EquipementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Equipement::class);
    }

    public function findAllEquipmentsByGang(int $gangId)
    {
        return $this->createQueryBuilder('g')
            ->leftjoin('g.ganger', 'f')
            ->Where('f.gang = :gangId')
            ->setParameter('gangId', $gangId)
            ->groupBy('g.name')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllWeaponEquipmentsByGang(int $gangId)
    {
        return $this->createQueryBuilder('g')
            ->leftjoin('g.weapon', 'w')
            ->leftjoin('w.ganger', 'f')
            ->Where('f.gang = :gangId')
            ->orWhere('w.stash = :gangId')
            ->setParameter('gangId', $gangId)
            ->groupBy('g.name')
            ->getQuery()
            ->getResult()
        ;
    }
}
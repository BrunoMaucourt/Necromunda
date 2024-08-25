<?php

namespace App\Repository;

use App\Entity\Skill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Skill>
 */
class SkillsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Skill::class);
    }

    public function findAllSkillsByGang(int $gangId)
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
}
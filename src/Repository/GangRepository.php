<?php

namespace App\Repository;

use App\Entity\Gang;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Gang>
 */
class GangRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gang::class);
    }

    public function getGangWithHighestRating(): ?array
    {
        return $this->createQueryBuilder('g')
            ->select('g.id, SUM(gr.rating) AS hidden rating')
            ->join('g.gangers', 'gr')
            ->groupBy('g.id')
            ->orderBy('rating', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getGangWithHighestCredits(): ?array
    {
        return $this->createQueryBuilder('g')
        ->select('g.id, g.credits')
        ->where('g.credits > 0')
        ->orderBy('g.credits', 'DESC')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult()
        ;
    }
}
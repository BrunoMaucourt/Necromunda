<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Game>
 */
class GamesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function getGangRatingsPerDate(): array
    {
        $qb = $this->createQueryBuilder('g')
            ->select('g.date, gang1.name AS gang1_name, g.gang1RatingAfterGame AS gang1_rating_after, g.gang1RatingBeforeGame AS gang1_rating_before, gang2.name AS gang2_name, g.gang2RatingBeforeGame AS gang2_rating_before, g.gang2RatingAfterGame AS gang2_rating_after')
            ->leftJoin('g.gang1', 'gang1')
            ->leftJoin('g.gang2', 'gang2')
            ->orderBy('g.date', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
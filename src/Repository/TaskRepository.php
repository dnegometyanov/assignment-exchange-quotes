<?php

namespace App\Repository;

use App\Entity\HistoricalQuotesTask;
use App\Entity\Listing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @inheritDoc
 */
class TaskRepository extends ServiceEntityRepository implements TaskRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoricalQuotesTask::class);
    }

    /**
     * @inheritDoc
     */
    public function findOneBySymbol(string $symbol): ?HistoricalQuotesTask
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.symbol = :val')
            ->setParameter('val', $symbol)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

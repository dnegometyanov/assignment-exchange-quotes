<?php

namespace App\Repository;

use App\Entity\HistoricalQuotesTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HistoricalQuotesTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoricalQuotesTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoricalQuotesTask[]    findAll()
 * @method HistoricalQuotesTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoricalQuotesTaskRepository extends ServiceEntityRepository implements HistoricalQuotesTaskRepositoryInterface
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

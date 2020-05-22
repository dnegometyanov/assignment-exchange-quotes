<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\HistoricalQuotesTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

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
    public function findOneByUuid(UuidInterface $uuid): ?HistoricalQuotesTask
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.uuid = :val')
            ->setParameter('val', $uuid)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

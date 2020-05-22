<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\HistoricalQuotesTask;
use Ramsey\Uuid\UuidInterface;

/**
 * @method HistoricalQuotesTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoricalQuotesTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoricalQuotesTask[]    findAll()
 * @method HistoricalQuotesTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface HistoricalQuotesTaskRepositoryInterface
{
    /**
     * @param UuidInterface $uuid
     *
     * @return HistoricalQuotesTask|null
     */
    public function findOneByUuid(UuidInterface $uuid): ?HistoricalQuotesTask;
}

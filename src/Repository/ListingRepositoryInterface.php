<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\HistoricalQuotesTask;
use App\Entity\Listing;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @method HistoricalQuotesTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoricalQuotesTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoricalQuotesTask[]    findAll()
 * @method HistoricalQuotesTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface ListingRepositoryInterface
{
    /**
     * @param string $symbol
     *
     * @throws NonUniqueResultException
     *
     * @return Listing|null
     *
     */
    public function findOneBySymbol(string $symbol): ?Listing;
}

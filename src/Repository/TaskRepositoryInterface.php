<?php

namespace App\Repository;

use App\Entity\HistoricalQuotesTask;
use App\Entity\Listing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HistoricalQuotesTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoricalQuotesTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoricalQuotesTask[]    findAll()
 * @method HistoricalQuotesTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface TaskRepositoryInterface
{
    /**
     * @param string $symbol
     *
     * @return HistoricalQuotesTask|null
     *
     * @throws NonUniqueResultException
     */
    public function findOneBySymbol(string $symbol): ?HistoricalQuotesTask;
}

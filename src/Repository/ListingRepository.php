<?php

namespace App\Repository;

use App\Entity\HistoricalQuotesTask;
use App\Entity\Listing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Listing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Listing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Listing[]    findAll()
 * @method Listing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListingRepository extends ServiceEntityRepository implements ListingRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Listing::class);
    }

    /**
     * @param string $symbol
     *
     * @return Listing|null
     *
     * @throws NonUniqueResultException
     */
    public function findOneBySymbol(string $symbol): ?Listing
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.symbol = :val')
            ->setParameter('val', $symbol)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

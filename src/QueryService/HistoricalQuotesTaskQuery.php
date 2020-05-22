<?php

namespace App\QueryService;

use App\Entity\HistoricalQuotesTask;
use App\Repository\HistoricalQuotesTaskRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class HistoricalQuotesTaskQuery implements HistoricalQuotesTaskQueryInterface
{
    /**
     * @var HistoricalQuotesTaskRepositoryInterface
     */
    private HistoricalQuotesTaskRepositoryInterface $taskRepository;

    public function __construct(
        HistoricalQuotesTaskRepositoryInterface $taskRepository
    )
    {
        $this->taskRepository = $taskRepository;
    }

    public function query(UuidInterface $uuid): ?HistoricalQuotesTask
    {
        return $this->taskRepository->findOneByUuid($uuid);
    }
}
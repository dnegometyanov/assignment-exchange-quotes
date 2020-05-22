<?php

namespace App\Message;

use DateTimeImmutable as DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

class HistoricalQuotesRequestEvent
{
    private string $symbol;
    private string $dateFrom;
    private string $dateTo;
    /**
     * @var UuidInterface
     */
    private UuidInterface $taskUuid;

    public function __construct(
        UuidInterface $taskUuid,
        string $symbol,
        string $dateFrom,
        string $dateTo
    )
    {
        $this->taskUuid = $taskUuid;
        $this->symbol   = $symbol;
        $this->dateFrom = $dateFrom;
        $this->dateTo   = $dateTo;
    }

    /**
     * @return UuidInterface
     */
    public function getTaskUuid(): UuidInterface
    {
        return $this->taskUuid;
    }

    /**
     * @return string
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    /**
     * @return string
     */
    public function getDateFrom(): string
    {
        return $this->dateFrom;
    }

    /**
     * @return string
     */
    public function getDateTo(): string
    {
        return $this->dateTo;
    }
}
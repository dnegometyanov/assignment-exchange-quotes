<?php

namespace App\QueryService;

use App\Entity\HistoricalQuotesTask;
use Ramsey\Uuid\UuidInterface;

interface HistoricalQuotesTaskQueryInterface
{
    public function query(UuidInterface $uuid): ?HistoricalQuotesTask;
}
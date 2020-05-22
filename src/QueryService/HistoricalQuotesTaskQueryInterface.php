<?php declare(strict_types=1);

namespace App\QueryService;

use App\Entity\HistoricalQuotesTask;
use Ramsey\Uuid\UuidInterface;

interface HistoricalQuotesTaskQueryInterface
{
    public function query(UuidInterface $uuid): ?HistoricalQuotesTask;
}

<?php declare(strict_types=1);

namespace App\Command;

use Ramsey\Uuid\UuidInterface as UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

class GetAndUpdateHistoricalQuotesCommand
{
    /**
     * @Assert\NotBlank()
     */
    private UuidInterface $taskUuid;

    /**
     * @Assert\NotBlank()
     */
    private string $symbol;

    /**
     * @Assert\Date
     */
    private string $dateFrom;
    /**
     * @Assert\Date
     *
     * @Assert\GreaterThan(propertyPath="dateFrom")
     */
    private string $dateTo;

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

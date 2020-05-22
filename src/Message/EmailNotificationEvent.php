<?php declare(strict_types=1);

namespace App\Message;

use Ramsey\Uuid\UuidInterface;

class EmailNotificationEvent
{
    private string $email;
    private string $companyName;
    private string $dateFrom;
    private string $dateTo;

    /**
     * @var UuidInterface
     */
    private UuidInterface $taskUuid;

    public function __construct(
        UuidInterface $taskUuid,
        string $email,
        string $companyName,
        string $dateFrom,
        string $dateTo
    )
    {
        $this->taskUuid    = $taskUuid;
        $this->email       = $email;
        $this->companyName = $companyName;
        $this->dateFrom    = $dateFrom;
        $this->dateTo      = $dateTo;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getCompanyName(): string
    {
        return $this->companyName;
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

    /**
     * @return UuidInterface
     */
    public function getTaskUuid(): UuidInterface
    {
        return $this->taskUuid;
    }
}

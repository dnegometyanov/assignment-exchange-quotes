<?php

namespace App\Command;

use Ramsey\Uuid\UuidInterface as UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

class SendNotificationEmailCommand
{
    /**
     * @Assert\NotBlank()
     */
    private UuidInterface $taskUuid;

    /**
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private string $email;

    /**
     * @Assert\NotBlank()
     */
    private string $companyName;

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
     * @return UuidInterface
     */
    public function getTaskUuid(): UuidInterface
    {
        return $this->taskUuid;
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
}

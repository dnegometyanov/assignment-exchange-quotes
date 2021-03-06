<?php declare(strict_types=1);

namespace App\Command;

use DateTime as DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class CreateHistoricalQuotesTaskCommand
{
    public function __construct(
        string $symbol,
        string $dateFrom,
        string $dateTo,
        string $email
    )
    {
        $this->symbol   = $symbol;
        $this->dateFrom = $dateFrom;
        $this->dateTo   = $dateTo;
        $this->email    = $email;
    }

    /**
     * @Assert\NotBlank()
     */
    private string $symbol;

    /**
     * @Assert\Date
     * @Assert\NotBlank
     * @Assert\LessThanOrEqual(propertyPath="todayAsString")
     */
    private string $dateFrom;

    /**
     * @Assert\Date
     * @Assert\NotBlank
     * @Assert\LessThanOrEqual(propertyPath="todayAsString")
     * @Assert\GreaterThan(propertyPath="dateFrom")
     */
    private string $dateTo;

    /**
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private string $email;

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
    public function getTodayAsString(): string
    {
        return (new DateTime())->format('Y-m-d');
    }
}

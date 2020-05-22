<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use DateTime as DateTime;
use DateTimeImmutable as DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface as UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class HistoricalQuotesTask
{
    public function __construct(
        string $symbol,
        DateTimeImmutable $dateFrom,
        DateTimeImmutable $dateTo,
        string $email
    )
    {
        $this->symbol = $symbol;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->email = $email;

        $this->isNotified = false;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function setData(array $data): HistoricalQuotesTask
    {
        $this->data = $data;

        return $this;
    }

    public function setIsNotified(bool $isNotified): HistoricalQuotesTask
    {
        $this->isNotified = $isNotified;

        return $this;
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    private UuidInterface $uuid;

    /**
     * @ORM\Column(type="string", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private string $symbol;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     *
     * @Assert\Date
     * @Assert\NotBlank()
     */
    private DateTimeImmutable $dateFrom;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     *
     * @Assert\Date
     * @Assert\NotBlank()
     */
    private DateTimeImmutable $dateTo;

    /**
     * @ORM\Column(type="string", nullable=false)
     *
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     *
     * @Assert\NotBlank()
     */
    private string $email;

    /**
     *
     * @ORM\Column(type="json", nullable=true, options={"default":null})
     */
    private array $data;

    /**
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default":false})
     */
    private bool $isNotified;

    /**
     * @Gedmo\Timestampable(on="create")
     * @Assert\NotBlank()
     * @ORM\Column(type="datetime")
     */
    private DateTimeImmutable $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @Assert\NotBlank()
     * @ORM\Column(type="datetime")
     */
    private DateTimeImmutable $updatedAt;

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDateFrom(): DateTimeImmutable
    {
        return $this->dateFrom;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDateTo(): DateTimeImmutable
    {
        return $this->dateTo;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return bool
     */
    public function isNotified(): bool
    {
        return $this->isNotified;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}

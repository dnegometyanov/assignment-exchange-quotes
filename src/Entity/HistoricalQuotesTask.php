<?php declare(strict_types=1);

namespace App\Entity;

use DateTime as DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface as UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=HistoricalQuotesTaskRepository::class)
 */
class HistoricalQuotesTask
{
    public function __construct(
        string $symbol,
        DateTime $dateFrom,
        DateTime $dateTo,
        string $email
    )
    {
        $this->symbol   = $symbol;
        $this->dateFrom = $dateFrom;
        $this->dateTo   = $dateTo;
        $this->email    = $email;

        $this->isNotified = false;
        $this->createdAt  = new DateTime();
        $this->updatedAt  = new DateTime();

        $this->data = null;
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
    private DateTime $dateFrom;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     *
     * @Assert\Date
     * @Assert\NotBlank()
     */
    private DateTime $dateTo;

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
    private ?array $data;

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
    private DateTime $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @Assert\NotBlank()
     * @ORM\Column(type="datetime")
     */
    private DateTime $updatedAt;

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @return DateTime
     */
    public function getDateFrom(): DateTime
    {
        return $this->dateFrom;
    }

    /**
     * @return DateTime
     */
    public function getDateTo(): DateTime
    {
        return $this->dateTo;
    }

    /**
     * @return array|null
     */
    public function getData(): ?array
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
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}

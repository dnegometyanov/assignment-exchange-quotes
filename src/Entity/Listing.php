<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ListingRepository::class)
 */
class Listing
{
    public function __construct(
        string $symbol,
        string $companyName
    )
    {
        $this->symbol = $symbol;
        $this->companyName = $companyName;
    }

    public function update(
        string $symbol,
        string $companyName
    )  {
        $this->symbol = $symbol;
        $this->companyName = $companyName;
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private string $symbol;

    /**
     * @ORM\Column(type="string", nullable=false)
     *
     * @Assert\Date
     */
    private string $companyName;

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
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
    public function getCompanyName(): string
    {
        return $this->companyName;
    }
}

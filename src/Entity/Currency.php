<?php

namespace App\Entity;

use App\Repository\CurrencyRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Doctrine\UuidGenerator;

#[ORM\Entity(repositoryClass: CurrencyRepository::class)]
class Currency
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface|string $id;

    #[ORM\Column(length: 100)]
    private ?string $name;

    #[ORM\Column(length: 100)]

    private ?string $currencyCode;

    #[ORM\Column(type: "integer")]
    private ?int $exchangeRate;

    #[ORM\Column(type: "integer")]
    private ?int $yesterdayExchangeRate;

    public function getId(): UuidInterface|string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCurrencyCode(): ?string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(string $currencyCode): self
    {
        $this->currencyCode = $currencyCode;

        return $this;
    }

    public function getExchangeRate(): ?int
    {
        return $this->exchangeRate;
    }

    public function setExchangeRate(int $exchangeRate): self
    {
        $this->exchangeRate = $exchangeRate;

        return $this;
    }

    public function getYesterdayExchangeRate(): ?int
    {
        return $this->yesterdayExchangeRate;
    }

    public function setYesterdayExchangeRate(int $yesterdayExchangeRate): self
    {
        $this->yesterdayExchangeRate = $yesterdayExchangeRate;

        return $this;
    }
}

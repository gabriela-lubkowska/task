<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: "App\Repository\CurrencyOrderItemRepository")]
class CurrencyOrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\ManyToOne(targetEntity: CurrencyOrder::class, inversedBy: "orderItems")]
    private $order;

    #[ORM\ManyToOne(targetEntity: Currency::class)]
    private $currency;

    #[ORM\Column(type: "integer")]
    private $quantity;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrder(): ?CurrencyOrder
    {
        return $this->order;
    }

    public function setOrder(?CurrencyOrder $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function setCurrency(?Currency $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
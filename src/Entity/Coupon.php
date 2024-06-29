<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CouponRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
class Coupon
{
    public const TYPE_FIXED = 1;
    public const TYPE_PERCENT = 2;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 3)]
    private string $code;

    #[ORM\Column(type: 'smallint')]
    private int $type;

    #[ORM\Column]
    private int $discount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDiscount(): int
    {
        return $this->discount;
    }

    public function setDiscount(int $discount): static
    {
        $this->discount = $discount;

        return $this;
    }
}

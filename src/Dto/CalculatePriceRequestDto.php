<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CalculatePriceRequestDto extends TaxCountryRequestDto
{
    #[Assert\GreaterThanOrEqual(value: 1)]
    #[Assert\NotNull]
    protected ?int $productId;

    #[Assert\Length(min: 2, max: 3)]
    protected ?string $couponCode;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->productId = $request->getPayload()->getInt('product');
        $this->couponCode = $request->getPayload()->get('couponCode');
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getCouponCode(): string
    {
        return $this->couponCode;
    }
}

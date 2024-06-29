<?php

declare(strict_types=1);

namespace App\Dto;

use App\Service\ShopService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class PurchaseRequestDto extends CalculatePriceRequestDto
{
    #[Assert\Choice(choices: [ShopService::PAYMENT_PAYPAL, ShopService::PAYMENT_STRIPE])]
    #[Assert\NotNull]
    protected ?string $paymentType;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->paymentType = $request->getPayload()->get('paymentProcessor');
    }

    public function getPaymentType(): string
    {
        return $this->paymentType;
    }
}

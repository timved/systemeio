<?php

declare(strict_types=1);

namespace App\Service;

use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class StripePayment implements PaymentInterface
{
    public function __construct(private StripePaymentProcessor $stripePaymentProcessor)
    {
    }

    public function pay(float $amount): bool
    {
        return $this->stripePaymentProcessor->processPayment($amount);
    }
}

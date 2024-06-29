<?php

declare(strict_types=1);

namespace App\Service;

use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

class PaypalPayment implements PaymentInterface
{
    public function __construct(private PaypalPaymentProcessor $paypalPaymentProcessor)
    {
    }

    public function pay(float $amount): bool
    {
        try {
            $this->paypalPaymentProcessor->pay((int)$amount);
        } catch (\Exception) {
            return false;
        }

        return true;
    }
}

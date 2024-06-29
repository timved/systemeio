<?php

declare(strict_types=1);

namespace App\Service;

class PaymentRouter
{
    /**
     * @var PaymentInterface[]
     */
    private array $payments = [];

    public function register(string $key, PaymentInterface $payment)
    {
        if (isset($this->payments[$key])) {
            throw new \LogicException(sprintf('Payment with key=%s already registered', $key));
        }

        $this->payments[$key] = $payment;
    }

    public function getPayment(string $key): PaymentInterface
    {
        if (!isset($this->payments[$key])) {
            throw new \LogicException(sprintf('Payment with key=%s not registered', $key));
        }

        return $this->payments[$key];
    }
}

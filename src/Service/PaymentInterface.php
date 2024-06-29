<?php

declare(strict_types=1);

namespace App\Service;

interface PaymentInterface
{
    public function pay(float $amount): bool;
}

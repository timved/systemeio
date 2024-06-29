<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Coupon;
use App\Entity\Product;
use App\Entity\Tax;

class ShopService
{
    public const string PAYMENT_PAYPAL = 'paypal';
    public const string PAYMENT_STRIPE = 'stripe';

    public function __construct(private PaymentRouter $paymentRouter)
    {
    }

    public function calculatePrice(Tax $tax, ?Coupon $coupon, Product $product): float
    {
        $price = $product->getPrice() + $tax->getAmount();

        if ($coupon) {
            $price = match ($coupon->getType()) {
                Coupon::TYPE_PERCENT => $price - ($price * $coupon->getDiscount() / 100),
                Coupon::TYPE_FIXED => $price - $coupon->getDiscount(),
            };
        }

        return (float)number_format($price, 2);
    }

    public function purchase(string $paymentType, float $price): bool
    {
        $payment = $this->paymentRouter->getPayment($paymentType);

        return $payment->pay($price);
    }
}

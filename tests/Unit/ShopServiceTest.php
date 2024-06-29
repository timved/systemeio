<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entity\Coupon;
use App\Entity\Product;
use App\Entity\Tax;
use App\Service\PaymentRouter;
use App\Service\PaypalPayment;
use App\Service\ShopService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ShopServiceTest extends TestCase
{
    private ShopService $shopService;
    private PaymentRouter $paymentRouter;
    private PaypalPayment $paypalPayment;

    public function setUp(): void
    {
        parent::setUp();

        $this->paymentRouter = $this->getMockBuilder(PaymentRouter::class)->disableOriginalConstructor()->getMock();
        $this->paypalPayment = $this->getMockBuilder(PaypalPayment::class)->disableOriginalConstructor()->getMock();
        $this->shopService = new ShopService($this->paymentRouter);
    }

    #[DataProvider('withCouponDataProvider')]
    public function testCalculatePriceWithCoupon(array $tax, array $product, array $coupon, float $expectedPrice): void
    {
        $tax = (new Tax())->setAmount($tax['amount']);
        $product = (new Product())->setPrice($product['price']);
        $coupon = (new Coupon())->setType($coupon['type'])->setDiscount($coupon['discount']);

        $price = $this->shopService->calculatePrice($tax, $coupon, $product);
        self::assertEquals($expectedPrice, $price);
    }

    #[DataProvider('withoutCouponDataProvider')]
    public function testCalculatePriceWithoutCoupon(array $tax, array $product, float $expectedPrice): void
    {
        $tax = (new Tax())->setAmount($tax['amount']);
        $product = (new Product())->setPrice($product['price']);

        $price = $this->shopService->calculatePrice($tax, null, $product);
        self::assertEquals($expectedPrice, $price);
    }

    public function testPurchase(): void
    {
        $this->paypalPayment->expects(self::once())->method('pay')->willReturn(true);
        $this->paymentRouter->expects(self::once())->method('getPayment')->willReturn(
            $this->paypalPayment,
        );

        $result = $this->shopService->purchase(ShopService::PAYMENT_PAYPAL, 107.56);
        self::assertTrue($result);
    }

    public static function withCouponDataProvider(): array
    {
        return [
            [
                'tax' => [
                    'amount' => 19,
                ],
                'product' => [
                    'price' => 100,
                ],
                'coupon' => [
                    'type' => Coupon::TYPE_FIXED,
                    'discount' => 10,
                ],
                'expectedPrice' => 109,
            ],
            [
                'tax' => [
                    'amount' => 19,
                ],
                'product' => [
                    'price' => 100,
                ],
                'coupon' => [
                    'type' => Coupon::TYPE_PERCENT,
                    'discount' => 10,
                ],
                'expectedPrice' => 107.1,
            ],
        ];
    }

    public static function withoutCouponDataProvider(): array
    {
        return [
            [
                'tax' => [
                    'amount' => 19,
                ],
                'product' => [
                    'price' => 100,
                ],
                'expectedPrice' => 119,
            ],
        ];
    }
}

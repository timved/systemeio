<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Coupon;
use App\Entity\Product;
use App\Entity\Tax;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Repository\TaxRepository;
use App\Service\ShopService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

abstract class AbstractShopController extends AbstractController
{
    public function __construct(
        protected CouponRepository $couponRepository,
        protected ProductRepository $productRepository,
        protected TaxRepository $taxRepository,
        protected ShopService $shopService)
    {
    }

    protected function getProduct(int $productId): Product
    {
        $product = $this->productRepository->find($productId);
        if (!$product) {
            throw new BadRequestHttpException('Product not found');
        }

        return $product;
    }

    protected function getTax(string $taxCountryCode): Tax
    {
        $tax = $this->taxRepository->findOneBy(['code' => $taxCountryCode]);
        if (!$tax) {
            throw new BadRequestHttpException('Tax country not found');
        }

        return $tax;
    }

    protected function getCoupon(?string $couponCode): ?Coupon
    {
        if (!$couponCode) {
            return null;
        }

        $coupon = $this->couponRepository->findOneBy(['code' => $couponCode]);
        if (!$coupon) {
            throw new BadRequestHttpException('Coupon not found');
        }

        return $coupon;
    }
}

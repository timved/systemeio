<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\PurchaseRequestDto;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/purchase', name: 'purchase', methods: ['POST'])]
class PurchaseController extends AbstractShopController
{
    public function __invoke(PurchaseRequestDto $requestDto): JsonResponse
    {
        $price = $this->shopService->calculatePrice(
            $this->getTax($requestDto->getCountryCode()),
            $this->getCoupon($requestDto->getCouponCode()),
            $this->getProduct($requestDto->getProductId())
        );

        $result = $this->shopService->purchase($requestDto->getPaymentType(), $price);

        return new JsonResponse(['accept' => $result], Response::HTTP_OK);
    }
}

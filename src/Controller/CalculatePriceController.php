<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\CalculatePriceRequestDto;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/calculate-price', name: 'calculate_price', methods: ['POST'])]
class CalculatePriceController extends AbstractShopController
{
    public function __invoke(CalculatePriceRequestDto $requestDto): JsonResponse
    {
        $price = $this->shopService->calculatePrice(
            $this->getTax($requestDto->getCountryCode()),
            $this->getCoupon($requestDto->getCouponCode()),
            $this->getProduct($requestDto->getProductId())
        );

        return new JsonResponse(['price' => $price], Response::HTTP_OK);
    }
}

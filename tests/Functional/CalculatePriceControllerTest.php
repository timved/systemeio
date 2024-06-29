<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CalculatePriceControllerTest extends WebTestCase
{
    public function testCalculatePriceControllerMethodTest(): void
    {
        $client = static::createClient();
        $product = $this->getContainer()->get(ProductRepository::class)->findOneBy(['price' => 100]);
        $client->request('POST', '/calculate-price', $post = [
            'product' => $product->getId(),
            'taxNumber' => 'DE123456789',
            'couponCode' => 'P10',
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $content = json_decode($client->getResponse()->getContent(), true);
        self::assertEquals(109.0, $content['price']);

        $client->request('POST', '/calculate-price', $post = [
            'product' => $product->getId(),
            'taxNumber' => 'DE123456789',
            'couponCode' => 'P50',
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $content = json_decode($client->getResponse()->getContent(), true);
        self::assertEquals(59.5, $content['price']);

        $client->request('POST', '/calculate-price', $post = [
            'product' => $product->getId(),
            'taxNumber' => 'IG123456789',
            'couponCode' => 'P50',
        ]);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $content = json_decode($client->getResponse()->getContent(), true);
        self::assertEquals('Invalid taxNumber', $content['error']);

        $client->request('POST', '/calculate-price', $post = [
            'taxNumber' => 'IG123456789',
            'couponCode' => 'P50',
        ]);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $content = json_decode($client->getResponse()->getContent(), true);
        self::assertEquals('productId This value should be greater than or equal to 1.', $content['error']);
    }
}

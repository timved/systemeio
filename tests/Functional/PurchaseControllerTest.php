<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PurchaseControllerTest extends WebTestCase
{
    public function testPurchaseControllerMethodTest(): void
    {
        $client = static::createClient();
        $product = $this->getContainer()->get(ProductRepository::class)->findOneBy(['price' => 100]);
        $client->request('POST', '/purchase', $post = [
            'product' => $product->getId(),
            'taxNumber' => 'DE123456789',
            'couponCode' => 'P10',
            'paymentProcessor' => 'paypal',
        ]);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $content = json_decode($client->getResponse()->getContent(), true);
        self::assertTrue($content['accept']);

        $client->request('POST', '/purchase', $post = [
            'product' => $product->getId(),
            'taxNumber' => 'DE123456789',
            'couponCode' => 'P10',
            'paymentProcessor' => 'stripe',
        ]);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $content = json_decode($client->getResponse()->getContent(), true);
        self::assertTrue($content['accept']);

        $client->request('POST', '/purchase', $post = [
            'product' => $product->getId(),
            'taxNumber' => 'DE123456789',
            'couponCode' => 'P10',
        ]);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $content = json_decode($client->getResponse()->getContent(), true);
        self::assertEquals('paymentType This value should not be null.', $content['error']);
    }
}

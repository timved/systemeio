<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    private const array DATA = [
        [
            'name' => 'Iphone',
            'price' => 100,
        ],
        [
            'name' => 'Наушники',
            'price' => 20,
        ],
        [
            'name' => 'Чехол',
            'price' => 10,
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $data) {
            $product = new Product();
            $product->setName($data['name']);
            $product->setPrice($data['price']);
            $manager->persist($product);
        }

        $manager->flush();
    }
}

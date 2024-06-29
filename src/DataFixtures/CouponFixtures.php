<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Coupon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CouponFixtures extends Fixture
{
    private const array DATA = [
        [
            'code' => 'P10',
            'type' => 1,
            'discount' => 10,
        ],
        [
            'code' => 'P50',
            'type' => 2,
            'discount' => 50,
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $data) {
            $coupon = new Coupon();
            $coupon->setCode($data['code']);
            $coupon->setType($data['type']);
            $coupon->setDiscount($data['discount']);
            $manager->persist($coupon);
        }

        $manager->flush();
    }
}

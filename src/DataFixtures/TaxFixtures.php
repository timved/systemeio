<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Tax;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TaxFixtures extends Fixture
{
    private const array DATA = [
        [
            'country' => 'Германия',
            'code' => 'DE',
            'amount' => 19,
        ],
        [
            'country' => 'Италия',
            'code' => 'IT',
            'amount' => 22,
        ],
        [
            'country' => 'Франция',
            'code' => 'FR',
            'amount' => 20,
        ],
        [
            'country' => 'Греция',
            'code' => 'GR',
            'amount' => 24,
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $data) {
            $tax = new Tax();
            $tax->setCountry($data['country']);
            $tax->setCode($data['code']);
            $tax->setAmount($data['amount']);
            $manager->persist($tax);
        }

        $manager->flush();
    }
}

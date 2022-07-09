<?php

namespace App\DataFixtures;

use App\Entity\ShopPlace;
use App\Entity\Unit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ShopPlaceFixtures extends Fixture
{
    public const SHOPPLACES = [
        'Supermarché',
        'Marché',
        'Bio / Vrac'
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::SHOPPLACES as $shopName) {
            $shop = new ShopPlace();
            $shop->setName($shopName);
            $this->addReference($shopName, $shop);
            $manager->persist($shop);
        }

        $manager->flush();
    }
}

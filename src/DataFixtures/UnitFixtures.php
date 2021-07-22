<?php

namespace App\DataFixtures;

use App\Entity\Unit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UnitFixtures extends Fixture
{
    const UNITS = [
        'unité',
        'g',
        'kg',
        'cc',
        'cs',
        'mL',
        'cL',
        'L',
    ];
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < count(self::UNITS); $i++) {
            $unit = new Unit();
            $unit->setName(self::UNITS[$i]);
            $manager->persist($unit);
        }

        $manager->flush();
    }
}

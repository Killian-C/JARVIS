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
        foreach (self::UNITS as $unitName) {
            $unit = new Unit();
            $unit->setName($unitName);
            $this->addReference($unitName, $unit);
            $manager->persist($unit);
        }

        $manager->flush();
    }
}

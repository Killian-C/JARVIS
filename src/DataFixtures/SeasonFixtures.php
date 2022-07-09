<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture
{
    public const SEASONS = [
        'Printemps' => [
            '2022-02-03',
            '2022-01-06'
        ],
        'Été' => [
            '2022-02-06',
            '2022-01-09'
        ],
        'Automne' => [
            '2022-02-09',
            '2022-01-12'
        ],
        'Hiver' => [
            '2022-02-12',
            '2023-01-03'
        ]
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::SEASONS as $seasonName => $date) {
            $season = new Season();
            $season->setName($seasonName);
            $season->setStartDate(new \DateTime($date[0]));
            $season->setEndDate(new \DateTime($date[1]));
            $manager->persist($season);
        }

        $manager->flush();
    }
}

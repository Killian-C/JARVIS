<?php

namespace App\DataFixtures;

use App\Entity\Aliment;
use App\Entity\Category;
use App\Entity\Unit;
use App\Repository\AlimentRepository;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class AlimentFixtures extends Fixture implements DependentFixtureInterface
{

    public const ALIMENTS = [
        'Oeuf'      => [
            'Viande',
            'unité',
            'Supermarché'
        ],
        'Aubergine' => [
            'Légume',
            'unité',
            'Marché'
        ],
        'Bacon'     => [
            'Viande',
            'g',
            'Supermarché'
        ],
        'Courgette' => [
            'Légume',
            'unité',
            'Marché'
        ],
        'Curry'     => [
            'Condiment',
            'cc',
            'Supermarché'
        ],
        'Tomate'    => [
            'Légume',
            'unité',
            'Marché'
        ],
        'Poivron'   => [
            'Légume',
            'unité',
            'Marché'
        ],
        'Sucre'     => [
            'Condiment',
            'g',
            'Bio / Vrac'
        ],
        'Farine'    => [
            'Condiment',
            'kg',
            'Bio / Vrac'
        ],
        'Chorizo'   => [
            'Viande',
            'g',
            'Supermarché'
        ],
        'Riz'       => [
            'Féculent',
            'g',
            'Bio / Vrac'
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::ALIMENTS as $alimentName => $data) {
            $aliment = new Aliment();
            $aliment->setName($alimentName);
            $aliment->setCategory($this->getReference($data[0]));
            $aliment->setUnit($this->getReference($data[1]));
            $aliment->setShopPlace($this->getReference($data[2]));
            $aliment->setPrettyName(sprintf('%s (%s)', $alimentName, $data[1]));
            $manager->persist($aliment);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            UnitFixtures::class,
            ShopPlaceFixtures::class
        ];
    }
}

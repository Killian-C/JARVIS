<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    const CATEGORIES = [
        'Boisson',
        'Condiment',
        'Fruit',
        'Gâteaux',
        'Laitage',
        'Légume',
        'Surgelé',
        'Viande',
    ];

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < count(self::CATEGORIES); $i++) {
            $category = new Category();
            $category->setName(self::CATEGORIES[$i]);
            $manager->persist($category);
            $this->addReference(self::CATEGORIES[$i], $category);
        }

        $manager->flush();
    }
}

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
        'Féculent'
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $this->addReference($categoryName, $category);
        }

        $manager->flush();
    }
}

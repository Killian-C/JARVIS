<?php

namespace App\DataFixtures;

use App\Entity\RecipeType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RecipeTypeFixtures extends Fixture
{
    public const RECIPE_TYPES = [
        'Entrée',
        'Plat',
        'Dessert',
        'Snack',
        'Apéro',
        'Plat trash',
        'Petit déj\''
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::RECIPE_TYPES as $recipeTypeName) {
            $recipeType = new RecipeType();
            $recipeType->setName($recipeTypeName);
            $manager->persist($recipeType);
        }

        $manager->flush();
    }
}

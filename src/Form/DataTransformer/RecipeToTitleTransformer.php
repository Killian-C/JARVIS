<?php


namespace App\Form\DataTransformer;


use App\Entity\Aliment;
use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;

class RecipeToTitleTransformer implements DataTransformerInterface
{

    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param $value
     * @return string
     */
    public function transform($value): string
    {
        $recipe = $value;// je dois faire ça à cause du contrat d'interface qui impose $value en params
        if ($recipe === null) {
            return '';
        }
        return $recipe->getTitle();
    }

    /**
     * @param $value
     * @return Recipe
     */
    public function reverseTransform($value): Recipe
    {
        $recipeTitle = $value; // je dois faire ça à cause du contrat d'interface qui impose $value en params
        /** @var Recipe $recipe */
        $recipe = $this->em->getRepository(Recipe::class)->findOneBy([ 'title' => $recipeTitle ]);
        return $recipe;
    }
}

<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use App\Repository\AlimentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/recipe", name="recipe_")
 */
class RecipeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param RecipeRepository $recipeRepository
     * @return Response
     */
    public function index(RecipeRepository $recipeRepository): Response
    {
        $recipes = $recipeRepository->findAll();
        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }
    
    /**
     * @Route("/new", name="new")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param AlimentRepository $alimentRepository
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $entityManager, AlimentRepository $alimentRepository): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($recipe->getIngredients() as $ingredient) {
                $ingredient->setRecipe($recipe);
            }
            $entityManager->persist($recipe);
            $entityManager->flush();
            return $this->redirectToRoute('recipe_index');
        }
        $aliments = $alimentRepository->findBy([], [ 'name' => 'ASC' ]);
        return $this->render('recipe/new.html.twig', [
            'form' => $form->createView(),
            'aliments' => $aliments,
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     * @param Recipe $recipe
     * @return Response
     */
    public function show(Recipe $recipe): Response
    {
        return $this->render('recipe/show.html.twig' , [
            'recipe' => $recipe
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     * @param Recipe $recipe
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param AlimentRepository $alimentRepository
     * @return Response
     */
    public function edit(Recipe $recipe, Request $request, EntityManagerInterface $entityManager, AlimentRepository $alimentRepository): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($recipe->getIngredients() as $ingredient) {
                if ($ingredient->getRecipe() === null) {
                    $ingredient->setRecipe($recipe);
                }
                $entityManager->persist($ingredient);
            }
            $entityManager->flush();
            return $this->redirectToRoute('recipe_index');
        }
        $aliments = $alimentRepository->findBy([], [ 'name' => 'ASC' ]);
        return $this->render('recipe/edit.html.twig', [
            'recipe' => $recipe,
            'form'   => $form->createView(),
            'aliments' => $aliments,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @param Recipe $recipe
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function delete(Recipe $recipe, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($recipe);
        $entityManager->flush();
        return $this->redirectToRoute('recipe_index');
    }
}


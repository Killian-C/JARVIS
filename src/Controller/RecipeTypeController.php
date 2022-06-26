<?php

namespace App\Controller;


use App\Entity\RecipeType;
use App\Form\RecipeTypeType;
use App\Repository\RecipeTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/recipetype")
 */
class RecipeTypeController extends AbstractController
{
    /**
     * @Route("/", name="recipetype_index")
     * @param RecipeTypeRepository $recipeTypeRepository
     * @return Response
     */
    public function index(RecipeTypeRepository $recipeTypeRepository): Response
    {
        return $this->render('recipetype/index.html.twig', [
            'recipetypes' => $recipeTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="recipetype_new")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $recipeType = new RecipeType();
        $recipeTypeType = $this->createForm(RecipeTypeType::class, $recipeType);
        $recipeTypeType->handleRequest($request);
        if ($recipeTypeType->isSubmitted() && $recipeTypeType->isValid()) {
            $em ->persist($recipeType);
            $em ->flush($recipeType);
            return $this->redirectToRoute('recipetype_index');
        }


        return $this->render('recipetype/new.html.twig', [
            'form' => $recipeTypeType->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="recipetype_edit")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param RecipeType $recipeType
     * @return Response
     */
    public function edit(Request $request, EntityManagerInterface $em, RecipeType $recipeType): Response
    {
        $recipeTypeType = $this->createForm(recipeTypeType::class, $recipeType);
        $recipeTypeType->handleRequest($request);
        if ($recipeTypeType->isSubmitted() && $recipeTypeType->isValid()) {
            $em ->flush($recipeType);
            return $this->redirectToRoute('recipetype_index');
        }


        return $this->render('recipetype/new.html.twig', [
            'recipetype' => $recipeType,
            'form'   => $recipeTypeType->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="recipetype_delete")
     * @param EntityManagerInterface $em
     * @param RecipeType $recipeType
     * @return Response
     */
    public function delete(EntityManagerInterface $em, RecipeType $recipeType): Response
    {
        $em->remove($recipeType);
        $em->flush();
        return $this->redirectToRoute('recipetype_index');
    }
}

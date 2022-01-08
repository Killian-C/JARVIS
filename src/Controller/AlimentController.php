<?php

namespace App\Controller;

use App\Entity\Aliment;
use App\Form\AlimentType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/aliment", name="aliment_")
 */
class AlimentController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findBy([], [ 'name' => 'ASC' ]);
        return $this->render('aliment/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $aliment = new Aliment();
        $form = $this->createForm(AlimentType::class, $aliment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $prettyName = sprintf('%s (%s)', $aliment->getName(), $aliment->getUnit()->getName());
            $aliment->setPrettyName($prettyName);
            $entityManager->persist($aliment);
            $entityManager->flush();

            return $this->redirectToRoute('aliment_index');
        }

        return $this->render('aliment/new.html.twig', [
           'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Request $request, Aliment $aliment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AlimentType::class, $aliment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('aliment_index');
        }

        return $this->render('aliment/edit.html.twig', [
           'aliment' => $aliment,
           'form'    => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Aliment $aliment, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($aliment);
        $entityManager->flush();
        return $this->redirectToRoute('aliment_index');
    }
}

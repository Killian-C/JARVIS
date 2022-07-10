<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Entity\Menu;
use App\Entity\Shift;
use App\Form\MenuType;
use App\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/menu", name="menu_")
 */
class MenuController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(MenuRepository $menuRepository): Response
    {
        $menus = $menuRepository->findBy([], ['startedAt' => 'DESC']);
        return $this->render('menu/index.html.twig', [
            'menus' => $menus,
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $menu = new Menu();
        foreach(Shift::SHIFT_IDENTIFIER as $shiftIdentifier) {
            $shift = new Shift();
            $shift->setIdentifier($shiftIdentifier);
            $menu->addShift($shift);
        }
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($menu->getShifts() as $shift) {
                foreach ($shift->getDishes() as $dish) {
                    $dish->setShift($shift);
                }
            }
            $entityManager->persist($menu);
            $entityManager->flush();
            return $this->redirectToRoute('menu_index');
        }
//        dd($form);
        return $this->render('menu/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Menu $menu)
    {
        return $this->render('menu/show.html.twig', [
           'menu' => $menu,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit", methods={"POST"})
     */
    public function edit(Menu $menu, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->redirectToRoute('menu_index');
        }

        return $this->render('menu/edit.html.twig', [
            'menu' => $menu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"POST"})
     */
    public function delete(Menu $menu, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($menu);
        $entityManager->flush();
        return $this->redirectToRoute('menu_index');
    }
}


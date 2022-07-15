<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Entity\Menu;
use App\Entity\Shift;
use App\Form\MenuDateStepType;
use App\Form\MenuType;
use App\Repository\MenuRepository;
use App\Service\MenuService;
use App\Service\ShiftService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
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
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ShiftService $shiftService
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $entityManager, ShiftService $shiftService): Response
    {
        $menu          = new Menu();
        $formDateStep  = $this->createForm(MenuDateStepType::class, $menu);
        $formShiftStep = $this->createForm(MenuType::class, $menu);

        $formDateStep->handleRequest($request);
        if ($formDateStep->isSubmitted() && $formDateStep->isValid()) {
            $start  = $menu->getStartedAt();
            $end    = $menu->getFinishedAt();
            $shifts = $shiftService->getShiftsByMenuDates($start, $end);
            foreach($shifts as $shiftIdentifier) {
                $shift = new Shift();
                $shift->setIdentifier($shiftIdentifier);
                $menu->addShift($shift);
            }
            $formShiftStep = $this->createForm(MenuType::class, $menu);
            return $this->render('menu/new.html.twig', [
                'form_shift_step' => $formShiftStep->createView(),
                'date_step' => false
            ]);
        }

        $formShiftStep->handleRequest($request);
        if ($formShiftStep->isSubmitted() && $formShiftStep->isValid()) {
            foreach ($menu->getShifts() as $shift) {
                $shift->setMenu($menu);
                foreach ($shift->getDishes() as $dish) {
                    $dish->setShift($shift);
                }
            }
            $entityManager->persist($menu);
            $entityManager->flush();
            return $this->redirectToRoute('menu_index');
        }

        return $this->render('menu/new.html.twig', [
            'form_date_step' => $formDateStep->createView(),
            'date_step'      => true
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Menu $menu)
    {
        $daysCount = (count($menu->getShifts()) - 1) / 2;
        return $this->render('menu/show.html.twig', [
            'days_count' => $daysCount,
            'menu'       => $menu
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


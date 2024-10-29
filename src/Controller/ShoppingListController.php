<?php

namespace App\Controller;

use App\Entity\Menu;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShoppingListController extends AbstractController
{
    /**
     * @Route("/shopping-list/{menu_id}", name="shoppingList")
     * @ParamConverter("menu", options={"mapping": {"menu_id": "id"}})
     */
    public function index(Menu $menu): Response
    {
        $currentShifts     = $menu->getShifts();
        $listOfIngredients = [];
        $occurrenceArray   = [];

        foreach ($currentShifts as $shift) {
            $dishes = $shift->getDishes();
            if ($dishes) {
                foreach ($dishes as $dish) {
                    $allIngredients = $dish->getIngredients();
                    foreach ($allIngredients as $ingredient) {
                        $newQuantity = $ingredient->getQuantity() * $dish->getPeopleCount();
                        $alimentName = $ingredient->getAliment()->getNameAndUnit();
                        if (!in_array($ingredient->getAliment(), $occurrenceArray, true)) {
                            $listOfIngredients[$alimentName] = $newQuantity;
                            $occurrenceArray[] = $ingredient->getAliment();
                        } else {
                            $listOfIngredients[$alimentName] += $newQuantity;
                        }
                    }
                }
            }
        }

        return $this->render('shopping_list/index.html.twig', [
            'menu'        => $menu,
            'ingredients' => $listOfIngredients,
        ]);
    }
}

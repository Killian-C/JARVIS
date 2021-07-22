<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\ShoppingList;
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
        $shoppingList = new ShoppingList();
        $shoppingList->setMenu($menu);
        $currentShifts = $menu->getShifts();
        $listOfIngredients = [];
        $occurenceArray = [];
        /*
        foreach ($currentShifts as $shift) {
            if ($shift->getRecipe()) {
                $allIngredients = $shift->getRecipe()->getIngredients();
                foreach ($allIngredients as $ingredient) {
                    if (!in_array($ingredient, $listOfIngredients)) {
                        $newQuantity = $ingredient->getQuantity() * $shift->getPeopleCount();
                        $ingredient->setQuantity($newQuantity);
                        $listOfIngredients[] = $ingredient;
                    } else {
                        $listOfIngredients
                    }
                }
            }
        }*/

        foreach ($currentShifts as $shift) {
            if ($shift->getRecipe()) {
                $allIngredients = $shift->getRecipe()->getIngredients();
                foreach ($allIngredients as $ingredient) {
                    if (!in_array($ingredient, $occurenceArray)) {
                        $newQuantity = $ingredient->getQuantity() * $shift->getPeopleCount();
                        $listOfIngredients[$ingredient->getAliment()->getName()] = $newQuantity;
                        $occurenceArray[] = $ingredient;
                    } else {
                        $newQuantity = $ingredient->getQuantity() * $shift->getPeopleCount();
                        $listOfIngredients[$ingredient->getAliment()->getName()] += $newQuantity;
                    }
                }
            }
        }
        return $this->render('shopping_list/index.html.twig', [
            'ingredients' => $listOfIngredients,
        ]);
    }
}

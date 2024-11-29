<?php

namespace App\Service;

use App\Entity\ListItem;
use App\Entity\Menu;
use App\Entity\ShoppingList;

class ListItemService
{
    /**
     * @param Menu $menu
     * @param ShoppingList $shoppingList
     * @return array
     */
    public function extractItemsFromMenu(Menu $menu, ShoppingList $shoppingList): array
    {
        $listItems       = [];
        $items           = [];
        $currentShifts   = $menu->getShifts();
        $occurrenceArray = [];

        foreach ($currentShifts as $shift) {
            $dishes = $shift->getDishes();
            if ($dishes) {
                foreach ($dishes as $dish) {
                    $allIngredients = $dish->getIngredients();
                    foreach ($allIngredients as $ingredient) {
                        $newQuantity = $ingredient->getQuantity() * $dish->getPeopleCount();
                        $alimentName = $ingredient->getAliment()->getNameAndUnit();
                        if (!in_array($ingredient->getAliment(), $occurrenceArray, true)) {
                            $items[$alimentName] = $newQuantity;
                            $occurrenceArray[] = $ingredient->getAliment();
                        } else {
                            $items[$alimentName] += $newQuantity;
                        }
                    }
                }
            }
        }

        return $this->hydrateListItems($shoppingList, $items);
    }

    /**
     * @param ShoppingList $shoppingList
     * @param array $items
     * @return array
     */
    private function hydrateListItems(ShoppingList $shoppingList, array $items): array
    {
        $listItems = [];

        foreach ($items as $itemName => $itemQuantity) {
            $listItem = new ListItem();
            $listItem
                ->setShoppingList($shoppingList)
                ->setContent($itemName)
                ->setQuantity($itemQuantity)
            ;

            $listItems[] = $listItem;
        }

        return $listItems;
    }

}
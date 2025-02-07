<?php

namespace App\Service;

use App\Entity\ListItem;
use App\Entity\Menu;
use App\Entity\ShoppingList;
use App\Repository\ShopPlaceRepository;

class ListItemService
{
    public const KEY_QUANTITY   = 'quantity';
    public const KEY_SHOP_PLACE = 'shopPlace';

    private ShopPlaceRepository $shopPlaceRepository;
    public function __construct(ShopPlaceRepository $shopPlaceRepository)
    {
        $this->shopPlaceRepository = $shopPlaceRepository;
    }

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
                        $alimentName = $ingredient->getAliment()->getPrettyName();
                        $items[$alimentName][self::KEY_SHOP_PLACE] = $ingredient->getAliment()->getShopPlace();

                        if (!in_array($ingredient->getAliment(), $occurrenceArray, true)) {
                            $items[$alimentName][self::KEY_QUANTITY] = $newQuantity;
                            $occurrenceArray[] = $ingredient->getAliment();
                        } else {
                            $items[$alimentName][self::KEY_QUANTITY] += $newQuantity;
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
        $currentItems = $shoppingList->getListItems()->toArray();

        foreach ($items as $itemName => $itemData) {

            $shopPlaceFromData = $itemData[self::KEY_SHOP_PLACE];
            $shopPlace         = $this->shopPlaceRepository->findOneBy(['id' => $shopPlaceFromData->getId()]);

            /**
             * Si je ne fais pas array_values, la key est conservée
             * Du coup $itemAlreadyInList[0] n'a plus de sens dans la suite du code (parce que je peux avoir le 1, le 2 etc. ...
            */
            $itemAlreadyInList = array_values(array_filter($currentItems, static function ($currentItem) use ($itemName) {
                return $currentItem->getContent() === $itemName;
            }));

            if ($itemAlreadyInList !== []) {
                $currentItem = $itemAlreadyInList[0];
                $previousQty = $currentItem->getQuantity();
                $newQty      = $previousQty + $itemData[self::KEY_QUANTITY];
                $currentItem->setQuantity($newQty);
                continue;
            }

            $listItem = new ListItem();
            $listItem
                ->setShoppingList($shoppingList)
                ->setContent($itemName)
                ->setQuantity($itemData[self::KEY_QUANTITY])
                ->setShopPlace($shopPlace)
            ;

            $listItems[] = $listItem;



        }

        return $listItems;
    }

}
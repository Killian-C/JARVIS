<?php

namespace App\Controller;

use App\Entity\ListItem;
use App\Entity\Menu;
use App\Entity\ShoppingList;
use App\Form\ShoppingListType;
use App\Repository\ListItemRepository;
use App\Repository\MenuRepository;
use App\Repository\ShoppingListRepository;
use App\Service\ListItemService;
use Doctrine\ORM\EntityManagerInterface;
use JsonException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shopping-list", name="shopping_list_")
 */
class ShoppingListController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param Request $request
     * @param ShoppingListRepository $shoppingListRepository
     * @return Response
     */
    public function index(Request $request, ShoppingListRepository $shoppingListRepository): Response
    {
        $shoppingLists = $shoppingListRepository->findAll();
        if (empty($shoppingLists)) {
           return $this->redirectToRoute('shopping_list_edit');
        }

        $shoppingList = $shoppingLists[0];

        return $this->render('shopping_list/index.html.twig', [
            'shopping_list' => $shoppingList,
        ]);
    }

    /**
     * @Route("/edit", name="edit")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ShoppingListRepository $shoppingListRepository
     * @return Response
     */
    public function edit(Request $request, EntityManagerInterface $em, ShoppingListRepository $shoppingListRepository): Response
    {
        $shoppingLists = $shoppingListRepository->findAll();
        if (empty($shoppingLists)) {
            $shoppingList = new ShoppingList();
        } else {
            $shoppingList = $shoppingLists[0];
        }

        $form = $this->createForm(ShoppingListType::class, $shoppingList);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($shoppingList);

            foreach ($shoppingList->getListItems() as $listItem) {
                $listItem->setShoppingList($shoppingList);
                $em->persist($listItem);
            }

            $em->flush();

            return $this->redirectToRoute('shopping_list_index');
        }

        return $this->render('shopping_list/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ShoppingListRepository $shoppingListRepository
     * @param ListItemService $listItemService
     * @param Menu $menu
     * @return Response
     * @Route("/add-items-from-menu/{menu_id}", name="add_items_from_menu")
     * @ParamConverter("menu", options={"mapping": {"menu_id": "id"}})
     */
    public function addItemsFromMenu(
        Request $request,
        EntityManagerInterface $em,
        ShoppingListRepository $shoppingListRepository,
        ListItemService $listItemService,
        Menu $menu
    ): Response
    {
        //On est sensé n'avoir qu'une seule liste de course
        $shoppingList = $shoppingListRepository->findAll()[0];
        $listItems    = $listItemService->extractItemsFromMenu($menu, $shoppingList);

        foreach ($listItems as $listItem) {
            $em->persist($listItem);
        }

        $em->flush();

        return $this->redirectToRoute('shopping_list_index');
    }


    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ListItemRepository $listItemRepository
     * @param ListItem $listItem
     * @return Response
     * @Route("/delete-list-item/{id}", name="delete_list_item")
     */
    public function deleteListItem(Request $request, EntityManagerInterface $em, ListItemRepository $listItemRepository, ListItem $listItem): Response
    {
        $em->remove($listItem);
        $em->flush();
        $this->addFlash("success", "List item deleted");
        return $this->redirectToRoute('shopping_list_index');
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ListItemRepository $listItemRepository
     * @return Response
     * @throws JsonException
     * @Route("/async-set-checked-on-list-item", name="async_set_checked_on_list_item", methods={"POST"})
     */
    public function asyncSetCheckedOnListItem(Request $request, EntityManagerInterface $em, ListItemRepository $listItemRepository): Response
    {
        $data       = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $listItemId = $data['listItemId'];
        $isChecked  = $data['isChecked'];
        $listItem   = $listItemRepository->findOneBy(['id' => $listItemId]);

        if ($listItem) {
            $listItem->setChecked($isChecked);
            $em->flush();
            return new JsonResponse(null, Response::HTTP_OK);
        }

        return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ListItemRepository $listItemRepository
     * @throws JsonException
     * @return Response
     * @Route("/async-delete-list-item", name="async_delete_list_item", methods={"POST"})
     */
    public function asyncDeleteListItem(Request $request, EntityManagerInterface $em, ListItemRepository $listItemRepository): Response
    {
        $data       = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $listItemId = $data['listItemId'];
        $listItem   = $listItemRepository->findOneBy(['id' => $listItemId]);
        if ($listItem) {
            $em->remove($listItem);
            $em->flush();
            return new JsonResponse(null, Response::HTTP_OK);
        }

        return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
    }

}

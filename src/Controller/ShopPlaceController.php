<?php

namespace App\Controller;

use App\Entity\ShopPlace;
use App\Form\ShopPlaceType;
use App\Repository\ShopPlaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/shopplace")
 */
class ShopPlaceController extends AbstractController
{
    /**
     * @Route("/", name="shopplace_index")
     * @param ShopPlaceRepository $shopPlaceRepository
     * @return Response
     */
    public function index(ShopPlaceRepository $shopPlaceRepository): Response
    {
        return $this->render('shopplace/index.html.twig', [
            'shopplaces' => $shopPlaceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="shopplace_new")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $shopPlace = new ShopPlace();
        $shopPlaceType = $this->createForm(ShopPlaceType::class, $shopPlace);
        $shopPlaceType->handleRequest($request);
        if ($shopPlaceType->isSubmitted() && $shopPlaceType->isValid()) {
            $em ->persist($shopPlace);
            $em ->flush($shopPlace);
            return $this->redirectToRoute('shopplace_index');
        }


        return $this->render('shopplace/new.html.twig', [
            'form' => $shopPlaceType->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="shopplace_edit")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ShopPlace $shopPlace
     * @return Response
     */
    public function edit(Request $request, EntityManagerInterface $em, ShopPlace $shopPlace): Response
    {
        $shopPlaceType = $this->createForm(ShopPlaceType::class, $shopPlace);
        $shopPlaceType->handleRequest($request);
        if ($shopPlaceType->isSubmitted() && $shopPlaceType->isValid()) {
            $em ->flush($shopPlace);
            return $this->redirectToRoute('shopplace_index');
        }


        return $this->render('shopplace/new.html.twig', [
            'shopplace' => $shopPlace,
            'form'   => $shopPlaceType->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="shopplace_delete")
     * @param EntityManagerInterface $em
     * @param ShopPlace $shopPlace
     * @return Response
     */
    public function delete(EntityManagerInterface $em, ShopPlace $shopPlace): Response
    {
        $em->remove($shopPlace);
        $em->flush();
        return $this->redirectToRoute('shopplace_index');
    }
}

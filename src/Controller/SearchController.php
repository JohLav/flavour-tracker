<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\CityRepository;
use App\Repository\ItemRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/search", name: "search_")]
class SearchController extends AbstractController
{
    #[Route("/", name: "index")]
    public function index(
        Request $request,
        ItemRepository $itemRepository,
        CityRepository $cityRepository,
        RestaurantRepository $restaurantRepository
    ): Response {
        // TODO : Ajouter autres tables concernées par le tri (ex. diet, category, etc.)
//        $timeSlot = null;
        $form = $this->createForm(SearchType::class);
//        $form = $this->createForm(SearchType::class, [
//            'items' => $request->request->all('search')['items'] ?? []
//        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $items = $data['items'];
//            $timeSlot = $data['timeSlot'];

            $restaurants = $restaurantRepository->findFiltered($data);
        }

        return $this->render('search/search.html.twig', [
            'form' => $form->createView(),
            'items' => $items ?? $itemRepository->findAll(),
            'restaurants' => $restaurants ?? $restaurantRepository->findAll(),
//            'timeSlot' => $timeSlot,
        ]);
    }
}

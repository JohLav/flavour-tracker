<?php

namespace App\Controller;

use App\Form\HomeSearchType;
use App\Form\SearchType;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/", name: "home_")]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, RestaurantRepository $restaurantRepository): Response
    {
        $form = $this->createForm(HomeSearchType::class);
        $form->handleRequest($request);

        $searchForm = $this->createForm(SearchType::class);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var array<mixed> $data */
            $data = $form->getData();

            return $this->render('search/search.html.twig', [
                'restaurants' => $restaurantRepository->findFiltered($data),
                'form' => $searchForm->createView(),
            ]);
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

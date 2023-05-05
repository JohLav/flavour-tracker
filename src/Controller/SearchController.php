<?php

// src/Controller/SearchController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SearchType;
use App\Repository\RestaurantRepository;

#[Route("/search", name: "search_")]
class SearchController extends AbstractController
{
    #[Route("/", name: "index")]
    public function index(Request $request, RestaurantRepository $repository): Response
    //ajouter les autres tables concernés par le trie, ex diet / category etc?
    {
        $form = $this->createForm(SearchType::class, [
            'items' => $request->request->all('search')['items'] ?? []
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $restaurants = $repository->findFiltered($data);

            return $this->render('home/_search_results.html.twig', [
                'restaurants' => $restaurants ?? $repository->findAll(),
            ]);
        }

        return $this->render('home/_search_bar.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

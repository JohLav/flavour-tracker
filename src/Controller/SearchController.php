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
    {

        $restaurants = [];
        $form = $this->createForm(SearchType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $restaurants = $repository->findFiltered($data);
            $restaurants;
        }

        return $this->render('home/search.html.twig', [
            'form' => $form->createView(),
            'restaurants' => $repository->findAll(),
        ]);
    }
}

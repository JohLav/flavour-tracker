<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RestaurantRepository;
use App\Form\HomeSearchType;

#[Route("/", name: "home_")]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, RestaurantRepository $repository): Response
    {
        $form = $this->createForm(HomeSearchType::class, [
            'items' => $request->request->all('home_search')['items'] ?? []
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $restaurants = $repository->findFiltered($data);

            return $this->render('home/search.html.twig', [
                'restaurants' => $restaurants ?? $repository->findAll(),
            ]);
        }
        return $this->render('home/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

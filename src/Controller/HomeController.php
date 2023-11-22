<?php

    namespace App\Controller;

    use App\Form\SearchType;
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
    public function index(Request $request, RestaurantRepository $restaurantRepository): Response
    {
        $form = $this->createForm(HomeSearchType::class, [
            'items' => $request->request->all('home_search')['items'] ?? []
        ]);

        $searchForm = $this->createForm(SearchType::class, [
            'items' => $request->request->all('search')['items'] ?? []
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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

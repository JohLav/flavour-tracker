<?php

    namespace App\Controller;

    use App\Entity\Restaurant;
    use App\Entity\User;
    use App\Repository\UserRepository;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

class FavoriteController extends AbstractController
{
    #[Route('/favorite', name: 'app_favorite')]
    public function index(): Response
    {
        return $this->render('favorite/favorite.html.twig', [
            'controller_name' => 'Favorite',
        ]);
    }

    #[Route('/favorite/new/{id}', name: 'app_favorite_new')]
    public function addFavorite(
        Request $request,
        Restaurant $restaurant,
        UserRepository $userRepository
    ): Response {
        /** @var User $user */
        $user = $this->getUser();
        $user->addFavorites($restaurant);

        $userRepository->save($user, true);

        return $this->redirectToRoute('search_index');
    }

    #[Route('/favorite/remove/{id}', name: 'app_favorite_remove')]
    public function removeFavorite(Restaurant $restaurant, UserRepository $userRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $user->removeFavorites($restaurant);

        $userRepository->save($user, true);

        return $this->redirectToRoute('app_favorite');
    }
}

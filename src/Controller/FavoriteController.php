<?php

    namespace App\Controller;

    use App\Entity\Restaurant;
    use App\Entity\User;
    use App\Repository\UserRepository;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

    #[Route("/favorite", name: "favorite_")]
class FavoriteController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/favorite/favorite.html.twig', [
            'controller_name' => 'Favorite',
        ]);
    }

    #[Route('/new/{id}', name: 'new')]
    public function new(
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

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Request $request, Restaurant $restaurant, UserRepository $userRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $user->removeFavorites($restaurant);

        $userRepository->save($user, true);
        $route = $request->headers->get('referer') === $this->generateUrl(
            'favorite_index',
            [],
            UrlGeneratorInterface::ABSOLUTE_URL
        ) ? 'favorite_index' : 'search_index';

        return $this->redirectToRoute($route);
    }
}

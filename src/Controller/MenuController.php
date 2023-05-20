<?php

    namespace App\Controller;

    use App\Entity\Item;
    use App\Entity\Menu;
    use App\Entity\User;
    use App\Form\ALaCarteType;
    use App\Form\MenuType;
    use App\Repository\ItemRepository;
    use App\Repository\MenuRepository;
    use App\Repository\RestaurantRepository;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    #[Route('/menus', name: 'menus_')]
    #[IsGranted('ROLE_OWNER')]
class MenuController extends AbstractController
{
    public function __construct(
        private MenuRepository $menuRepository
    ) {
    }

    /**
     * Menus list
     */
    #[Route('/list', name: 'list')]
    public function menusList(
        MenuRepository $menuRepository,
    ): Response {
        /** @var User $connectedUser */
        $connectedUser = $this->getUser();
        $restaurant = $connectedUser->getRestaurant();

        $menus = $this->menuRepository->findBy([
            'restaurant' => $restaurant
        ]);

        return $this->render('admin/menu/list.html.twig', [
            'menus' => $menus
        ]);
    }

    #[Route('/{categoryName}', name: 'show')]
    public function show(string $categoryName, MenuRepository $menuRepository): Response
    {
        /** @var User $connectedUser */
        $connectedUser = $this->getUser();
        $restaurant = $connectedUser->getRestaurant();

        $menus = $this->menuRepository->findBy([
            'restaurant' => $restaurant
        ]);

        $category = $this->menuRepository->findOneBy(
            ['name' => $categoryName],
        );

        if (!$category) {
            throw $this->createNotFoundException(
                "La catégorie $categoryName est introuvable."
            );
        }

        return $this->render('admin/menu/show.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * Add a new menu
     */
    #[Route('/new', name: 'new')]
    public function new(Request $request, MenuRepository $menuRepository): Response
    {
        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        /** @var User $connectedUser */
        $connectedUser = $this->getUser();
        $restaurant = $connectedUser->getRestaurant();

        if ($form->isSubmitted() && $form->isValid()) {
            $menu->setRestaurant($restaurant);
            $menuRepository->save($menu, true);
            $this->addFlash('success', 'Le menu a bien été ajouté.');

            return $this->redirectToRoute('menus_list');
        }

        return $this->renderForm('admin/menu/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Edit a specific menu
     */
    #[Route('/edit/{id}', name: 'edit')]
    public function edit(
        Request $request,
        Menu $menu,
        MenuRepository $menuRepository
    ): Response {
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $menuRepository->save($menu, true);
            $this->addFlash('success', 'Le menu a bien été ajouté.');

            return $this->redirectToRoute('menus_list');
        }

        return $this->renderForm('admin/menu/edit.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Delete a specific menu
     */
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(
        Request $request,
        Menu $menu,
        MenuRepository $menuRepository
    ): Response {

        $menuRepository->remove($menu, true);
        $this->addFlash('success', 'Le menu a bien été supprimé.');

        return $this->redirectToRoute('menus_list');
    }
}

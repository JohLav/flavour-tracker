<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Menu;
use App\Entity\User;
use App\Form\ALaCarteType;
use App\Form\MenuType;
use App\Repository\ItemRepository;
use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard', name: 'dashboard_')]
class MenuController extends AbstractController
{
    public function __construct(
        private MenuRepository $menuRepository
    )
    {
    }

    #[Route('/menus', name: 'index')]
    public function index(MenuRepository $menuRepository): Response
    {
//        /** @var User $connectedUser */
//        $connectedUser = $this->getUser();
//        $restaurant = $connectedUser->getRestaurant();
//
//        $menus = $this->menuRepository->findBy([
//            'restaurant' => $restaurant
//        ]);

        return $this->render('menu/index.html.twig', [

        ]);
    }

//    #[Route('/{categoryName}', name: 'show')]
//    public function show(string $categoryName, MenuRepository $menuRepository): Response
//    {
//        /** @var User $connectedUser */
//        $connectedUser = $this->getUser();
//        $restaurant = $connectedUser->getRestaurant();
//
//        $menus = $this->menuRepository->findBy([
//            'restaurant' => $restaurant
//        ]);
//
//        $category = $this->menuRepository->findOneBy(
//            ['name' => $categoryName],
//        );
//
//        if (!$category) {
//            throw $this->createNotFoundException(
//                "La catégorie $categoryName est introuvable."
//            );
//        }
//
//        return $this->render('menu/show.html.twig', [
//            'category' => $category,
//        ]);
//    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, MenuRepository $menuRepository): Response
    {
        // Créer une nouvelle instance de l'entité Menu
        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);
//        /** @var User $connectedUser */
//        $connectedUser = $this->getUser();
//        $restaurant = $connectedUser->getRestaurant();
        if ($form->isSubmitted() && $form->isValid()) {
//            $menu->setRestaurant($restaurant);
            $menuRepository->save($menu, true);
            $this->addFlash('success', 'Le menu a bien été ajouté.');

            return $this->redirectToRoute('dashboard_index');
        }

        return $this->renderForm('menu/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/carte', name: 'carte')]
    public function carte(Request $request, ItemRepository $itemRepository): Response
    {
        $item = new Item();
        $form = $this->createForm(ALaCarteType::class, $item);
        $form->handleRequest($request);
//        /** @var User $connectedUser */
//        $connectedUser = $this->getUser();
//        $restaurant = $connectedUser->getRestaurant();
        if ($form->isSubmitted() && $form->isValid()) {
//            $item->setRestaurant($restaurant);
            $itemRepository->save($item, true);
            $this->addFlash('success', "L'élément a bien été ajouté.");

            return $this->redirectToRoute('dashboard_index');
        }

        return $this->renderForm('menu/carte.html.twig', [
            'form' => $form,
        ]);
    }
}

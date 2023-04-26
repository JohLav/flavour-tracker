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
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('menu/index.html.twig', [
            'menu_controller' => 'Restaurateur',
        ]);
    }

    #[Route('/menu', name: 'menu')]
    public function menu(): Response
    {

        return $this->render('menu/menu.html.twig', [
            'menu_controller' => 'Menu',
        ]);
    }

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

            return $this->redirectToRoute('dashboard_menu');
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

            return $this->redirectToRoute('dashboard_menu');
        }

        return $this->renderForm('menu/carte.html.twig', [
            'form' => $form,
        ]);
    }
}

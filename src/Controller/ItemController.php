<?php

    namespace App\Controller;

    use App\Entity\Item;
    use App\Entity\User;
    use App\Form\ALaCarteType;
    use App\Repository\ItemRepository;
    use Symfony\Component\Security\Http\Attribute\IsGranted;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    #[Route('/items', name: 'items_')]
    #[IsGranted('ROLE_OWNER')]
class ItemController extends AbstractController
{
    public function __construct(
        private ItemRepository $itemRepository
    ) {
    }

    /**
     * Items list
     */
    #[Route('/list', name: 'list')]
    public function itemsList(
        ItemRepository $itemRepository,
    ): Response {
        /** @var User $connectedUser */
        $connectedUser = $this->getUser();
        $restaurant = $connectedUser->getRestaurant();

        $items = $this->itemRepository->findBy([
            'restaurant' => $restaurant
        ]);

        return $this->render('admin/item/list.html.twig', [
            'items' => $items
        ]);
    }

    /**
     * Add a new item
     */
    #[Route('/new', name: 'new')]
    public function item(Request $request, ItemRepository $itemRepository): Response
    {
        $item = new Item();
        $form = $this->createForm(ALaCarteType::class, $item);
        $form->handleRequest($request);

        /** @var User $connectedUser */
        $connectedUser = $this->getUser();
        $restaurant = $connectedUser->getRestaurant();

        if ($form->isSubmitted() && $form->isValid()) {
            $item->setRestaurant($restaurant);
            $itemRepository->save($item, true);
            $this->addFlash('success', "L'élément a bien été ajouté.");

            return $this->redirectToRoute('items_list');
        }

        return $this->renderForm('admin/item/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Edit a specific item
     */
    #[Route('/edit/{id}', name: 'edit')]
    public function edit(
        Request $request,
        Item $item,
        ItemRepository $itemRepository
    ): Response {
        $form = $this->createForm(ALaCarteType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemRepository->save($item, true);
            $this->addFlash('success', "L'élément a bien été modifié.");

            return $this->redirectToRoute('items_list');
        }

        return $this->renderForm('admin/item/edit.html.twig', [
            'form' => $form,
            'item' => $item
        ]);
    }

    /**
     * Delete a specific item
     */
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(
        Request $request,
        Item $item,
        ItemRepository $itemRepository
    ): Response {

        $itemRepository->remove($item, true);
        $this->addFlash('success', "L'élément a bien été supprimé.");

        return $this->redirectToRoute('items_list');
    }
}

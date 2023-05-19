<?php

    namespace App\Controller;

    use App\Entity\Restaurant;
    use App\Entity\TimeSlot;
    use App\Form\TimeSlotType;
    use App\Repository\TimeSlotRepository;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    #[Route('/time/slot')]
    #[IsGranted('ROLE_OWNER')]
class TimeSlotController extends AbstractController
{
    #[Route('/', name: 'app_time_slot_index', methods: ['GET'])]
    public function index(TimeSlotRepository $timeSlotRepository): Response
    {
        return $this->render('time_slot/index.html.twig', [
            'time_slots' => $timeSlotRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_time_slot_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        Restaurant $restaurant,
        TimeSlotRepository $timeSlotRepository
    ): Response {
        $timeSlot = new TimeSlot();
        $form = $this->createForm(TimeSlotType::class, $timeSlot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $timeSlot->setRestaurant($restaurant);
            $timeSlotRepository->save($timeSlot, true);

            return $this->redirectToRoute('app_restaurant_show', ['id' => $restaurant->getId()]);
        }

        return $this->renderForm('time_slot/new.html.twig', [
            'time_slot' => $timeSlot,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_time_slot_show', methods: ['GET'])]
    public function show(TimeSlot $timeSlot): Response
    {
        return $this->render('time_slot/show.html.twig', [
            'time_slot' => $timeSlot,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_time_slot_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        TimeSlot $timeSlot,
        TimeSlotRepository $timeSlotRepository
    ): Response {
        $form = $this->createForm(TimeSlotType::class, $timeSlot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $restaurant = $timeSlot->getRestaurant();
            $timeSlotRepository->save($timeSlot, true);

            return $this->redirectToRoute('app_restaurant_show', ['id' => $restaurant->getId()]);
        }

        return $this->renderForm('time_slot/edit.html.twig', [
            'time_slot' => $timeSlot,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_time_slot_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        TimeSlot $timeSlot,
        TimeSlotRepository $timeSlotRepository
    ): Response {
        $restaurant = $timeSlot->getRestaurant();

        if ($this->isCsrfTokenValid('delete' . $timeSlot->getId(), $request->request->get('_token'))) {
            $timeSlotRepository->remove($timeSlot, true);
        }

        return $this->redirectToRoute('app_restaurant_show', ['id' => $restaurant->getId()], Response::HTTP_SEE_OTHER);
    }
}

<?php

    namespace App\Controller;

    use App\Entity\Restaurant;
    use App\Entity\User;
    use App\Repository\ReservRepository;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use App\Entity\Reservation;
    use App\Form\ReservationType;
    use Symfony\Component\HttpFoundation\Request;

    #[Route("/reservation", name: "reservation_")]
class ReservationController extends AbstractController
{
    #[Route('/new', name: 'new', methods: ["GET", "POST"])]
    public function new(
        Request $request,
        Restaurant $restaurant,
        ReservRepository $reservRepository
    ): Response {
        $reservation = new  Reservation();
        $form = $this->createForm(ReservationType::class, $reservation, [
            'attr' => ['class' => 'form']
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->security->getUser();
            $reservation->setUser($user);
            $reservation->setRestaurant($restaurant);
            $reservation->setPaymentMode('CREDIT_CARD');

            $reservRepository->save($reservation, true);

            $this->addFlash('success', 'Votre réservation a bien été enregistrée.');


            return $this->redirectToRoute('reservation_confirmation');
        }

        return $this->render('reservation/reserv.html.twig', [
            'form' => $form->createView(),
            'restaurant' => $restaurant
        ]);
    }

    #[Route('/confirmation', name: 'confirmation')]
    public function confirmReservation(): Response
    {
        return $this->render('reservation/index.html.twig');
    }

    #[Route('/list', name: 'list')]
    public function index(
        Request $request,
        ReservRepository $reservRepository
    ): Response {
        /** @var User $user */
        $user = $this->security->getUser();
        $reservations = $user->getReservations();
        // return $this->render('reserv/index.html.twig', ['reservations' => $reservations]);}

        if ($request->isMethod('POST')) {
            $selectedReservations = array_filter($request->request->all('selected_reservations'), 'is_scalar');

            if ($selectedReservations) {
                $action = $request->request->get('action');

                if ($action === 'edit') {
                    if (is_scalar($selectedReservations[0])) {
                        // Redirigez vers la route 'reservation_edit' avec l'ID de la première réservation sélectionnée
                        return $this->redirectToRoute('reservation_edit', ['id' => $selectedReservations[0]]);
                    } else {
                        $this->addFlash('error', "Une erreur s'est produite lors de la réservation.");
                    }
                } elseif ($action === 'delete') {
                    foreach ($selectedReservations as $reservationId) {
                        $reservation = $reservRepository->find($reservationId);
                        $reservRepository->remove($reservation, true);
                    }
                    $this->addFlash('success', "Les réservations sélectionnées ont bien été supprimées.");
                    return $this->redirectToRoute('reservation_list');
                }
            }
        }

        return $this->render('reserv/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit', methods: ["GET", "POST"])]
    public function editReservation(
        Request $request,
        Reservation $reservation,
        ReservRepository $reservRepository
    ): Response {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservRepository->save($reservation, true);

            $this->addFlash('success', 'Votre réservation a bien été modifiée.');

            return $this->redirectToRoute('reservation_list');
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ["POST", "GET"])]
    public function deleteReservation(
        Request $request,
        Reservation $reservation,
        ReservRepository $reservRepository
    ): Response {
        $reservRepository->remove($reservation, true);
        $this->addFlash('success', 'Votre réservation a bien été supprimée.');


        return $this->redirectToRoute('reservation_list');
    }
}

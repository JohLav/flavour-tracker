<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Entity\User;
use App\Repository\ReservationRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ReservationController extends AbstractController
{
    private Security $security;
    private AuthorizationCheckerInterface $authorizationChecker;

    public function __construct(Security $security,AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->security = $security;
        $this->authorizationChecker = $authorizationChecker;
    }
    #[Route('/reservation/new', name: 'app_reservation', methods: ["GET", "POST"])]
    public function new(
        Request               $request,
        RestaurantRepository  $restaurantRepository,
        ReservationRepository $reservationRepository,
    ): Response {
        $reservation = new  Reservation();
        $form = $this->createForm(ReservationType::class, $reservation, [
            'attr' => ['class' => 'my-form-class']
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                // Redirigez les utilisateurs non connectés vers la page de connexion/inscription
                return $this->redirectToRoute('app_login'); // Remplacez 'app_login' par le nom de la route de votre page de connexion/inscription
            }

            $user = $this->security->getUser();
            $reservation->setUser($user);


            // A SUPPRIMER QUAND J'AURAIS LA PARTI D'INES
            $restaurant = new Restaurant();
            $restaurant = $restaurantRepository->find(['id' => 1]);
            //
            $reservation->setRestaurant($restaurant);
            $reservation->setPaymentMode('CREDIT_CARD');

            $reservationRepository->save($reservation, true);

            $this->addFlash('success', 'Votre réservation a bien été enregistrée.');


            return $this->redirectToRoute('reservation_confirmation');
        }

        return $this->render('reservation/reserv.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/reservation/confirmation', name:'reservation_confirmation')]
    public function confirmReservation(): Response
    {
        return $this->render('reservation/show.html.twig');
    }

    #[Route('/reservation/list', name: 'app_reservation_list')]
    public function index(Request $request, ReservationRepository $reservationRepository): Response
    {
        /** @var User $user */
        $user = $this->security->getUser();
        $reservations = $user->getReservations();

//
  //      return $this->render('reserv/index.html.twig', [
     //       'reservations' => $reservations,
       // ]);
    //}

        if ($request->isMethod('POST')) {
            $selectedReservations = array_filter($request->request->all('selected_reservations'), 'is_scalar');

            if ($selectedReservations) {
                $action = $request->request->get('action');

                if ($action === 'edit') {
                    if (is_scalar($selectedReservations[0])) {
                    // Redirigez vers la route 'reservation_edit' avec l'ID de la première réservation sélectionnée
                    return $this->redirectToRoute('reservation_edit', ['id' => $selectedReservations[0]]);
                    } else {
                        $this->addFlash('error', 'Une erreur s\'est produite lors de la sélection des réservations.');
                    }
                } elseif ($action === 'delete') {
                    foreach ($selectedReservations as $reservationId) {
                        $reservation = $reservationRepository->find($reservationId);
                        $reservationRepository->remove($reservation, true);
                    }
                    $this->addFlash('success', 'Les réservations sélectionnées ont bien été supprimées.');
                    return $this->redirectToRoute('app_reservation_list');
                }
            }
        }

        return $this->render('reserv/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }


    #[Route('/reservation/{id}/edit', name: 'reservation_edit', methods: ["GET", "POST"])]
    public function editReservation(Request $request, Reservation $reservation,  ReservationRepository $reservationRepository): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservationRepository->save($reservation, true);

            $this->addFlash('success', 'Votre réservation a bien été modifiée.');

            return $this->redirectToRoute('app_reservation_list');
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/reservation/{id}/delete', name: 'reservation_delete', methods: ["POST", "GET"])]
    public function deleteReservation(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        $reservationRepository->remove($reservation, true);
        $this->addFlash('success', 'Votre réservation a bien été supprimée.');


        return $this->redirectToRoute('app_reservation_list');
    }

}

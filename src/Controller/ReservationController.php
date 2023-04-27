<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class ReservationController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    #[Route('/reservation/new', name: 'app_reservation', methods: ["GET", "POST"])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation, [
            'attr' => ['class' => 'my-form-class']
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->security->getUser();
            $reservation->setUser($user);

            $entityManager->persist($reservation);
            $entityManager->flush();

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
}

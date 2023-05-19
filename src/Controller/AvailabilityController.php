<?php

    namespace App\Controller;

    use App\Entity\Reservation;
    use App\Entity\Restaurant;
    use App\Form\ReservationType;
    use DateTime;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

class AvailabilityController extends AbstractController
{
    #[Route('/reserve', name: 'reserve_table')]
    public function reserveTable(
        Request $request,
        EntityManagerInterface $em
    ): Response {
        // create reservation form
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // check if a reservation is possible
            $availableSeats = $this->getAvailableSeats(
                $reservation->getRestaurant(),
                $reservation->getDate(),
                $reservation->getTime()
            );

            if ($availableSeats >= $reservation->getSeats()) {
                // save reservation if enough seats are available
                $em->persist($reservation);
                $em->flush();

                // add success message
                $this->addFlash('success', 'La réservation a été effectuée avec succès.');

                return $this->redirectToRoute('home');
            } else {
                // add error message if no seats are available
                $this->addFlash('error', 'Il n\'y a pas assez de places disponibles pour cette réservation.');
            }
        }

        // get available times for the selected date
        $restaurant = $reservation->getRestaurant();
        $availableTimes = $this->getAvailableTimes($restaurant, $reservation->getDate());

        return $this->render('reservation/reserve.html.twig', [
            'form' => $form->createView(),
            'available_times' => $availableTimes,
        ]);
    }

    private function getAvailableTimes(Restaurant $restaurant, DateTime $date)
    {
        // ...
    }

    #[Route('/available-times/{restaurant}/{date}', name: 'available_times')]
    public function availableTimes(Restaurant $restaurant, DateTime $date)
    {
        $availableTimes = $this->getAvailableTimes($restaurant, $date);

        return $this->json($availableTimes);
    }
}

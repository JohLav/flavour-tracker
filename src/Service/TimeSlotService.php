<?php

namespace App\Service;

use App\Entity\Restaurant;
use App\Repository\ReservationRepository;
use App\Repository\RestaurantRepository;
use App\Repository\TimeSlotRepository;
use DateTime;

class TimeSlotService
{
    public function __construct(private ReservationRepository $reservationRepository)
    {
    }
    public function checkAvailable(Restaurant $restaurant, DateTime $dateTime): bool
    {
        $capacity = $restaurant->getCapacity();

        $reservations = $this->reservationRepository->findReservationByTimeSlot(
            $restaurant,
            $dateTime
        );

        $total = 0;
        foreach ($reservations as $reservation) {
            $total += $reservation->getAdultNb() + $reservation->getKidNb();
        }

        return $capacity - $total > 0;
    }
}

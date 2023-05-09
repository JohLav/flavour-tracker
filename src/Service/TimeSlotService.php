<?php

namespace App\Service;

use App\Entity\Restaurant;
use App\Repository\ReservationRepository;
use App\Repository\RestaurantRepository;
use App\Repository\TimeSlotRepository;

class TimeSlotService
{
    public function __construct(private RestaurantRepository $restaurantRepository, private ReservationRepository $reservationRepository)
    {
    }
    public function checkAvailable(Restaurant $restaurant, \DateTime $dateTime)
    {
        $capacity = $restaurant->getCapacity();
        $reservations = $this->reservationRepository->findBy([
            'restaurant' => $restaurant,
            'datetime' => $dateTime->format('y-m-d')
        ]);

        $total = 0;
        foreach ($reservations as $reservation) {
            $total += $reservation->getAdultNb() + $reservation->getKidNb();
        }

        dd($total);
        return $capacity - $total > 0;

    }

}

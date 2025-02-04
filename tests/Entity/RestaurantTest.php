<?php

namespace App\Tests\Entity;

use App\Entity\Restaurant;
use PHPUnit\Framework\TestCase;

class RestaurantTest extends TestCase
{
    public function testDefault(): void
    {
        $restaurant = new Restaurant();
        $restaurant->setName('Bouchon lyonnais');
        $restaurant->setPhone(123456789);
        $restaurant->setCapacity(50);
        $restaurant->setAddress('5 Rue des Gourmets, Lyon');

        $this->assertSame('Bouchon lyonnais', $restaurant->getName());
        $this->assertSame(123456789, $restaurant->getPhone());
        $this->assertSame(50, $restaurant->getCapacity());
        $this->assertSame('5 Rue des Gourmets, Lyon', $restaurant->getAddress());
    }
}

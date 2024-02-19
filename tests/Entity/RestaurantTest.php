<?php

    namespace App\Tests\Entity;

    use App\Entity\Restaurant;
    use PHPUnit\Framework\TestCase;

class RestaurantTest extends TestCase
{
    public function testDefault(): void
    {
        $restaurant = new Restaurant('Comme à la maison', '');
        $this->assertSame(null, $restaurant->getName());
    }
}

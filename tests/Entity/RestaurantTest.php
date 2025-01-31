<?php

    namespace App\Tests\Entity;

    use App\Entity\Restaurant;
    use PHPUnit\Framework\TestCase;

class RestaurantTest extends TestCase
{
    public function testDefault(): void
    {
        $restaurant = new Restaurant();
        $this->assertSame('Bouchon Lyonnais', $restaurant->getName());
    }
}

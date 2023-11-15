<?php

    namespace App\Tests\Controller;

    use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testShowLogin()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}

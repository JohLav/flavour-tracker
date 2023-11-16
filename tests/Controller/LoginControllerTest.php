<?php

    namespace App\Tests\Controller;

    use App\Repository\UserRepository;
    use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testShowLogin(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('john.doe@example.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // Request a specific page
        $client->request('GET', '/login/');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello John!');
    }
}

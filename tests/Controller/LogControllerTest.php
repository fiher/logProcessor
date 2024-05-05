<?php
declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class LogControllerTest extends WebTestCase
{
    public function testCountWithFilterStatusCode(): void
    {
        $client = static::createClient();

        $client->request('GET', '/logs/count?statusCode=201');

        $this->assertResponseIsSuccessful();
    }

    public function testCount(): void
    {
        $client = static::createClient();

        $client->request('GET', '/logs/count');

        $this->assertResponseIsSuccessful();
    }
}
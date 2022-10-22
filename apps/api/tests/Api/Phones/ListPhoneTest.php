<?php

declare(strict_types=1);

namespace App\Tests\Api\Phones;

use App\Entity\Customer;
use App\Tests\Api\ApiTestCase;
use App\Tests\Api\Helpers\AssertResponse;
use App\Tests\Api\Helpers\PhoneFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class ListPhoneTest extends ApiTestCase
{
    use AssertResponse;
    use PhoneFactory;

    public function testAGuestCannotListCustomerUsers(): void
    {
        $client = static::createClient();
        $client->xmlHttpRequest('GET', '/api/phones');

        $this->assertResponseStatusCodeSame(401);
    }

    public function testAClientCanListItsCustomerUsers(): void
    {
        $client = static::createClient();
        $oauthClient = $this->createOAuthClient();
        $token = $this->getAccessTokenFor($oauthClient, $client);

        $this->createManyPhones(25);

        $client->xmlHttpRequest(
            'GET',
            '/api/phones',
            server: ['HTTP_AUTHORIZATION' => 'Bearer ' . $token]
        );

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHasCount($client, 10, 'items');

        $client->xmlHttpRequest(
            'GET',
            '/api/phones?page=3&limit=10',
            server: ['HTTP_AUTHORIZATION' => 'Bearer ' . $token]
        );

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHasCount($client, 5, 'items');
    }

    private function createManyPhones(int $n): array
    {
        $phones = [];

        for ($i = 1; $i <= $n; $i++) {
            $phones[] = $this->createPhone([
                'name' => 'iPhone ' . $i,
                'brand' => 'Apple',
                'price' => 99999,
                'description' => 'The iPhone 12 is a smartphone designed, developed, and marketed by Apple Inc.',
                'createdAt' => new \DateTimeImmutable('2020-10-23 12:00:00'),
            ]);
        }

        return $phones;
    }
}

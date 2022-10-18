<?php

declare(strict_types=1);

namespace App\Tests\Api\CustomerUsers;

use App\Entity\Customer;
use App\Tests\Api\ApiTestCase;
use App\Tests\Api\Helpers\AssertResponse;
use App\Tests\Api\Helpers\CustomerUserFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class ListCustomerUserTest extends ApiTestCase
{
    use CustomerUserFactory;
    use AssertResponse;

    public function testAGuestCannotListCustomerUsers(): void
    {
        $client = static::createClient();
        $client->xmlHttpRequest('GET', '/api/customer_users');

        $this->assertResponseStatusCodeSame(401);
    }

    public function testAClientCanListItsCustomerUsers(): void
    {
        $client = static::createClient();
        $oauthClient = $this->createOAuthClient();
        $token = $this->getAccessTokenFor($oauthClient, $client);

        $this->createManyCustomerUsers($client, $oauthClient, 25);

        $client->xmlHttpRequest(
            'GET',
            '/api/customer_users',
            server: ['HTTP_AUTHORIZATION' => 'Bearer ' . $token]
        );

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHasCount($client, 10, 'items');

        $client->xmlHttpRequest(
            'GET',
            '/api/customer_users?page=3&limit=10',
            server: ['HTTP_AUTHORIZATION' => 'Bearer ' . $token]
        );

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHasCount($client, 5, 'items');
    }

    private function createManyCustomerUsers(KernelBrowser $client, Customer $oauthClient, int $n): array
    {
        $customerUsers = [];
        for ($i = 1; $i <= $n; $i++) {
            $customerUsers[] = $this->createCustomerUser(
                client: $oauthClient,
                email: 'johndoe' . $i . '@example.com',
                firstName: 'John ',
                lastName: 'Doe ' . $i
            );
        }

        return $customerUsers;
    }
}

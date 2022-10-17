<?php

declare(strict_types=1);

namespace App\Tests\Api\CustomerUsers;

use App\Tests\Api\ApiTestCase;
use App\Tests\Api\Helpers\AssertResponse;
use App\Tests\Api\Helpers\CustomerUserFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetCustomerUserDetailsTest extends ApiTestCase
{
    use CustomerUserFactory;
    use AssertResponse;

    public function testAGuestCannotSeeAUserDetails(): void
    {
        $client = static::createClient();
        $client->xmlHttpRequest(Request::METHOD_GET, '/api/customer_users/1');

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testAClientCanSeeOneOfItsUser(): void
    {
        $client = static::createClient();
        $oauthClient = $this->createOAuthClient();
        $token = $this->getAccessTokenFor($oauthClient, $client);

        $customerUser = $this->createCustomerUser(
            client: $oauthClient,
            email: 'johndoe@example.com',
            firstName: 'John',
            lastName: 'Doe'
        );

        $client->xmlHttpRequest(
            Request::METHOD_GET,
            '/api/customer_users/' . $customerUser->getId(),
            server: ['HTTP_AUTHORIZATION' => 'Bearer ' . $token]
        );

        $this->assertResponseIsSuccessful();

        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('data', $response);
        $this->assertEquals(
            [
                'id' => $customerUser->getId(),
                'email' => 'johndoe@example.com',
                'firstName' => 'John',
                'lastName' => 'Doe',
            ],
            $response['data']
        );
        $this->assertResponseHasLink($client, 'self', '/api/customer_users/' . $customerUser->getId());
        $this->assertResponseHasLink($client, 'delete', '/api/customer_users/' . $customerUser->getId());
    }

    public function testAClientCannotSeeAUserOfAnotherClient(): void
    {
        $client = static::createClient();
        $oauthClient = $this->createOAuthClient();
        $token = $this->getAccessTokenFor($oauthClient, $client);

        $customerUser = $this->createCustomerUser(
            client: $this->createOAuthClient("Another client", "another_client"),
            email: 'johndoe@example.com',
            firstName: 'John',
            lastName: 'Doe'
        );

        $client->xmlHttpRequest(
            Request::METHOD_GET,
            '/api/customer_users/' . $customerUser->getId(),
            server: ['HTTP_AUTHORIZATION' => 'Bearer ' . $token]
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Api\CustomerUsers;

use App\Repository\CustomerUserRepositoryInterface;
use App\Tests\Api\ApiTestCase;
use App\Tests\Api\Helpers\CustomerUserFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteCustomerUserTest extends ApiTestCase
{
    use CustomerUserFactory;

    public function testAGuestCannotDeleteAUser(): void
    {
        $client = static::createClient();
        $client->xmlHttpRequest(Request::METHOD_DELETE, '/api/customer_users/1');

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testAClientCannotDeleteAnotherClientUser(): void
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
            Request::METHOD_DELETE,
            '/api/customer_users/' . $customerUser->getId(),
            server: ['HTTP_AUTHORIZATION' => 'Bearer ' . $token]
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testAClientCanDeleteOneOfItsCustomerUser(): void
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
            Request::METHOD_DELETE,
            '/api/customer_users/' . $customerUser->getId(),
            server: ['HTTP_AUTHORIZATION' => 'Bearer ' . $token]
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        /** @var CustomerUserRepositoryInterface $customerUserRepository */
        $customerUserRepository = $this->getContainer()->get(CustomerUserRepositoryInterface::class);
        $this->assertCount(0, $customerUserRepository->all());
    }
}

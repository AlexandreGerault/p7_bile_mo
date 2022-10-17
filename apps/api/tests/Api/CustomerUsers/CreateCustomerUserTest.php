<?php

namespace App\Tests\Api\CustomerUsers;

use App\Repository\CustomerUserRepositoryInterface;
use App\Tests\Api\ApiTestCase;
use App\Tests\Api\Helpers\AssertResponse;
use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateCustomerUserTest extends ApiTestCase
{
    use AssertResponse;
    
    public function testAUserCannotBeCreatedWithoutAuthentication(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_POST, '/api/customer_users');

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testAUserAuthenticatedCanCreateACustomerUser(): void
    {
        $client = static::createClient();
        $oauthClient = $this->createOAuthClient();

        $token = $this->getAccessTokenFor($oauthClient, $client);

        $params = [
            'email' => 'johndoe@example.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
        ];

        $client->xmlHttpRequest(
            Request::METHOD_POST,
            '/api/customer_users',
            parameters: $params,
            server: ['HTTP_AUTHORIZATION' => 'Bearer ' . $token]
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        /** @var CustomerUserRepositoryInterface $customerUserRepository */
        $customerUserRepository = $this->getContainer()->get(CustomerUserRepositoryInterface::class);
        $this->assertCount(1, $customerUserRepository->all());

        $responseContent = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('data', $responseContent);
        $this->assertArrayHasKey('id', $responseContent['data']);
        $this->assertArrayHasKey('email', $responseContent['data']);
        $this->assertArrayHasKey('firstName', $responseContent['data']);
        $this->assertArrayHasKey('lastName', $responseContent['data']);

        $this->assertResponseHasLink($client, 'self', '/api/customer_users/' . $responseContent['data']['id']);
        $this->assertResponseHasLink($client, 'delete', '/api/customer_users/' . $responseContent['data']['id']);

        $customerUser = $customerUserRepository->findByEmail('johndoe@example.com');
        $this->assertEquals($oauthClient->getIdentifier(), $customerUser?->getClient()->getIdentifier());
    }

    /** @dataProvider provideInvalidPayload */
    public function testItCannotCreateACustomerUserWithInvalidPayload($params): void
    {
        $client = static::createClient();
        $oauthClient = $this->createOAuthClient();

        $token = $this->getAccessTokenFor($oauthClient, $client);

        $client->xmlHttpRequest(
            Request::METHOD_POST,
            '/api/customer_users',
            parameters: $params,
            server: ['HTTP_AUTHORIZATION' => 'Bearer ' . $token]
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);

        /** @var CustomerUserRepositoryInterface $customerUserRepository */
        $customerUserRepository = $this->getContainer()->get(CustomerUserRepositoryInterface::class);
        $this->assertCount(0, $customerUserRepository->all());
    }

    public function provideInvalidPayload(): Generator
    {
        yield [
            [
                'email' => 'johndoe',
                'firstName' => 'John',
                'lastName' => 'Doe',
            ],
        ];
        yield [
            [
                'email' => 'johndoe@example.com',
                'firstName' => '',
                'lastName' => 'Doe',
            ],
        ];
        yield [
            [
                'email' => 'johndoe@example.com',
                'firstName' => 'John',
                'lastName' => '',
            ],
        ];
    }
}

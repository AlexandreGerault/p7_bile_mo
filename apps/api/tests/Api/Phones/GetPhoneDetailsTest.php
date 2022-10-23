<?php

declare(strict_types=1);

namespace App\Tests\Api\Phones;

use App\Tests\Api\ApiTestCase;
use App\Tests\Api\Helpers\AssertResponse;
use App\Tests\Api\Helpers\PhoneFactory;

class GetPhoneDetailsTest extends ApiTestCase
{
    use AssertResponse;
    use PhoneFactory;

    public function testAGuestCannotSeeAPhoneDetails(): void
    {
        $client = static::createClient();
        $client->xmlHttpRequest('GET', '/api/phones/1');

        $this->assertResponseStatusCodeSame(401);
    }

    public function testAClientCanSeeOneAPhoneDetails(): void
    {
        $client = static::createClient();
        $oauthClient = $this->createOAuthClient();
        $token = $this->getAccessTokenFor($oauthClient, $client);

        $phone = $this->createPhone([
            'name' => 'iPhone 12',
            'brand' => 'Apple',
            'price' => 99999,
            'description' => 'The iPhone 12 is a smartphone designed, developed, and marketed by Apple Inc.',
            'createdAt' => new \DateTimeImmutable('2020-10-23 12:00:00'),
        ]);

        $client->xmlHttpRequest(
            'GET',
            '/api/phones/' . $phone->getId(),
            server: ['HTTP_AUTHORIZATION' => 'Bearer ' . $token]
        );

        $this->assertResponseStatusCodeSame(200);

        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('data', $response);
        $this->assertEquals(
            [
                'id' => $phone->getId(),
                'brand' => [
                    'name' => 'Apple',
                ],
                'model' => 'iPhone 12',
                'price' => 99999,
                'description' => 'The iPhone 12 is a smartphone designed, developed, and marketed by Apple Inc.',
                'createdAt' => '2020-10-23T12:00:00+00:00',
            ],
            $response['data']
        );
        $this->assertResponseHasLink($client, 'self', '/api/phones/' . $phone->getId());
    }
}

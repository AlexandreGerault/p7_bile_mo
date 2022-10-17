<?php

declare(strict_types=1);

namespace App\Tests\Api\CustomerUsers;

use App\Tests\Api\ApiTestCase;
use App\Tests\Api\Helpers\CustomerUserFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetCustomerUserDetailsTest extends ApiTestCase
{
    use CustomerUserFactory;

    public function testAGuestCannotSeeAUserDetails(): void
    {
        $client = static::createClient();
        $client->xmlHttpRequest(Request::METHOD_GET, '/api/customer_users/1');

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }
}

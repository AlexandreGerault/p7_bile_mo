<?php

declare(strict_types=1);

namespace App\Tests\Api\Helpers;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;

trait AssertResponse
{
    public function getResponseFromKernelBrowser(KernelBrowser $client): array
    {
        return json_decode($client->getResponse()->getContent(), true);
    }

    public function assertResponseHasLink(KernelBrowser $client, string $name, string $link): void
    {
        $response = $this->getResponseFromKernelBrowser($client);

        $this->assertEquals($link, $response['links'][$name]);
    }

    public function assertResponseHasCount(KernelBrowser $client, int $count, string $key): void
    {
        $response = $this->getResponseFromKernelBrowser($client);

        $this->assertArrayHasKey($key, $response);
        $this->assertCount($count, $response[$key]);
    }
}

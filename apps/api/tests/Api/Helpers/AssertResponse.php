<?php

declare(strict_types=1);

namespace App\Tests\Api\Helpers;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;

trait AssertResponse
{
    public function assertResponseHasLink(KernelBrowser $client, string $name, string $link): void
    {
        $response = $this->getResponseFromKernelBrowser($client);
        $this->assertArrayHasKey('url', $response['links'][$name]);
        $this->assertEquals($link, $response['links'][$name]['url']);
    }

    public function getResponseFromKernelBrowser(KernelBrowser $client): array
    {
        return json_decode($client->getResponse()->getContent(), true);
    }
}

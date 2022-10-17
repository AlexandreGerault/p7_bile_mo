<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Entity\Customer;
use League\Bundle\OAuth2ServerBundle\Manager\ClientManagerInterface;
use League\Bundle\OAuth2ServerBundle\Model\Client;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ApiTestCase extends WebTestCase
{
    protected function createOAuthClient(): Customer
    {
        /** @var ClientManagerInterface $em */
        $em = $this->getContainer()->get(ClientManagerInterface::class);

        $client = new Customer("Test", "test", "test");
        $client->setActive(true);
        $client->setAllowPlainTextPkce(true);

        $em->save($client);

        return $client;
    }

    public function getAccessTokenFor(Customer $oauthClient, KernelBrowser $client): string
    {
        $client->xmlHttpRequest(Request::METHOD_POST, '/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $oauthClient->getIdentifier(),
            'client_secret' => $oauthClient->getSecret(),
        ]);

        $response = $client->getResponse()->getContent();
        $response = json_decode($response, true);

        return $response['access_token'];
    }
}

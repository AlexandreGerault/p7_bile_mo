<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use League\Bundle\OAuth2ServerBundle\Manager\ClientManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ApiTestCase extends WebTestCase
{
    protected function createOAuthClient(?string $name = null, ?string $identifier = null): Customer
    {
        /** @var ClientManagerInterface $em */
        $em = $this->getContainer()->get(ClientManagerInterface::class);

        $client = new Customer($name ?? "Test", $identifier ?? "test", $identifier ?? "test");
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

    public function getEntityManagerInterface(): EntityManagerInterface
    {
        $container = $this->getContainer();

        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);

        return $em;
    }
}
